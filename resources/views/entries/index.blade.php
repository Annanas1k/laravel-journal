@extends('layouts.app')

@section('title', 'Jurnalul meu')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <h2 style="color:#6b4f3a;">Jurnalul lui {{ Auth::user()->name }}</h2>
    <a href="{{ route('entries.create') }}" class="btn btn-primary">+ Notita nouă</a>
</div>

@if($allTags->count() > 0)
    <div style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
        <span style="font-size: 0.9rem; color: #6b4f3a;">Filtrează:</span>
        <a href="{{ route('entries.index') }}" 
           style="text-decoration: none; font-size: 0.8rem; padding: 4px 10px; border-radius: 15px; background: {{ !request('tag') ? '#6b4f3a' : '#e8d9cc' }}; color: {{ !request('tag') ? '#fff' : '#6b4f3a' }};">
           Toate
        </a>
        @foreach($allTags as $tag)
            <a href="{{ route('entries.index', ['tag' => $tag->name]) }}" 
               style="text-decoration: none; font-size: 0.8rem; padding: 4px 10px; border-radius: 15px; background: {{ request('tag') == $tag->name ? '#6b4f3a' : '#e8d9cc' }}; color: {{ request('tag') == $tag->name ? '#fff' : '#6b4f3a' }};">
               #{{ $tag->name }}
            </a>
        @endforeach
    </div>
@endif

@if($entries->isEmpty())
    <div class="card" style="text-align:center; padding:2.5rem;">
        <p style="color:#9e8878; font-size:1.05rem;">Nu ai nicio notita încă. Adaugă prima ta pagină!</p>
    </div>
@else
    @foreach($entries as $entry)
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div style="flex:1;">
                <h3 style="color:#6b4f3a; margin-bottom:0.3rem;">
                    <a href="{{ route('entries.show', $entry) }}" style="text-decoration:none; color:inherit;">
                        {{ $entry->title }}
                    </a>
                </h3>
                
                <div style="margin-bottom: 0.5rem;">
                    <small style="color:#9e8878;">
                        {{ $entry->created_at->format('d M Y, H:i') }}
                        @if($entry->mood)
                            &nbsp;·&nbsp; {{ ucfirst($entry->mood) }}
                        @endif
                    </small>

                    {{-- Afișare rapidă a tag-urilor sub dată --}}
                    @if($entry->tags->count() > 0)
                        <div style="display: flex; gap: 0.4rem; margin-top: 0.3rem; flex-wrap: wrap;">
                            @foreach($entry->tags as $tag)
                                <span style="background: #efedea; color: #8a6d59; padding: 1px 6px; border-radius: 4px; font-size: 0.7rem; border: 1px solid #e0d8d0;">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <p style="margin-top:0.7rem; color:#5a4a40; font-size:0.93rem; line-height:1.6;">
                    {{ Str::limit($entry->content, 150) }}
                </p>
            </div>
            
            <div style="margin-left:1rem; display:flex; gap:0.5rem; flex-shrink:0;">
                <a href="{{ route('entries.edit', $entry) }}" class="btn btn-secondary btn-sm">Editează</a>
                <form action="{{ route('entries.destroy', $entry) }}" method="POST"
                      onsubmit="return confirm('Ești sigur că vrei să ștergi această intrare?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Șterge</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endif
@endsection