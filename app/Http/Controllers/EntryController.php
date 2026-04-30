<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    // Afișează toate intrările utilizatorului cu tag-urile aferente
    public function index(Request $request)
    {
        $query = Auth::user()->entries()->with('tags');

        // Dacă utilizatorul a dat click pe un tag (ex: ?tag=Facultate)
        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $entries = $query->latest()->get();
        
        // Luăm toate tag-urile utilizatorului pentru a afișa meniul de filtrare
        $allTags = Tag::whereHas('entries', function($q) {
            $q->where('user_id', Auth::id());
        })->get();

        return view('entries.index', compact('entries', 'allTags'));
    }

    // Formular pentru intrare nouă
    public function create()
    {
        $tags = Tag::all(); // Trimitem toate tag-urile disponibile pentru selecție
        return view('entries.create', compact('tags'));
    }

    // Salvează intrarea nouă și asociază tag-urile
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|min:2|max:100',
            'content' => 'required|min:5',
            'mood'    => 'nullable|in:fericit,trist,neutru,energic,obosit',
            'tags'    => 'nullable|array',
            'tags.*'  => 'exists:tags,id',
        ]);

        // 1. Creăm intrarea (fără tag-uri, deoarece nu sunt în tabelul 'entries')
        $entry = Auth::user()->entries()->create([
            'title'   => $request->title,
            'content' => $request->content,
            'mood'    => $request->mood,
        ]);

        // 2. Atașăm tag-urile în tabela pivot 'entry_tag'
        if ($request->has('tags')) {
            $entry->tags()->attach($request->tags);
        }

        return redirect()->route('entries.index')
                         ->with('success', 'Intrare adăugată cu succes!');
    }

    // Afișează o singură intrare
    public function show(Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }

        return view('entries.show', compact('entry'));
    }

    // Formular de editare
    public function edit(Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }

        $tags = Tag::all();
        return view('entries.edit', compact('entry', 'tags'));
    }

    // Salvează modificările și actualizează tag-urile
    public function update(Request $request, Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'   => 'required|min:2|max:100',
            'content' => 'required|min:5',
            'mood'    => 'nullable|in:fericit,trist,neutru,energic,obosit',
            'tags'    => 'nullable|array',
            'tags.*'  => 'exists:tags,id',
        ]);

        // Actualizăm datele de bază din tabelul 'entries'
        $entry->update([
            'title'   => $request->title,
            'content' => $request->content,
            'mood'    => $request->mood,
        ]);

        // Sincronizăm tag-urile în tabela pivot (șterge vechile legături și pune doar pe cele noi)
        $entry->tags()->sync($request->tags ?? []);

        return redirect()->route('entries.index')
                         ->with('success', 'Intrare actualizată!');
    }

    // Șterge intrarea
    public function destroy(Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }

        // Legăturile din 'entry_tag' vor fi șterse automat datorită 'cascade'
        $entry->delete();

        return redirect()->route('entries.index')
                         ->with('success', 'Intrare ștearsă.');
    }
}