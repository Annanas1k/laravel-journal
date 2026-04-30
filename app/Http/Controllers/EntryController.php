<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    // Afișează toate intrările utilizatorului curent
    public function index()
    {
        // Doar intrările userului autentificat, ordonate după dată
        $entries = Auth::user()->entries()->latest()->get();
        return view('entries.index', compact('entries'));
    }

    // Formular pentru intrare nouă
    public function create()
    {
        return view('entries.create');
    }

    // Salvează intrarea nouă
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|min:2|max:100',
            'content' => 'required|min:5',
            'mood'    => 'nullable|in:fericit,trist,neutru,energic,obosit',
        ]);

        Auth::user()->entries()->create([
            'title'   => $request->title,
            'content' => $request->content,
            'mood'    => $request->mood,
        ]);

        return redirect()->route('entries.index')
                         ->with('success', 'Intrare adăugată cu succes!');
    }

    // Afișează o singură intrare
    public function show(Entry $entry)
    {
        // Securitate: verificăm că intrarea aparține userului curent
        if ($entry->user_id !== Auth::id()) {
            abort(403, 'Acces interzis.');
        }

        return view('entries.show', compact('entry'));
    }

    // Formular de editare
    public function edit(Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403, 'Acces interzis.');
        }

        return view('entries.edit', compact('entry'));
    }

    // Salvează modificările
    public function update(Request $request, Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403, 'Acces interzis.');
        }

        $request->validate([
            'title'   => 'required|min:2|max:100',
            'content' => 'required|min:5',
            'mood'    => 'nullable|in:fericit,trist,neutru,energic,obosit',
        ]);

        $entry->update([
            'title'   => $request->title,
            'content' => $request->content,
            'mood'    => $request->mood,
        ]);

        return redirect()->route('entries.index')
                         ->with('success', 'Intrare actualizată!');
    }

    // Șterge intrarea
    public function destroy(Entry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403, 'Acces interzis.');
        }

        $entry->delete();

        return redirect()->route('entries.index')
                         ->with('success', 'Intrare ștearsă.');
    }
}