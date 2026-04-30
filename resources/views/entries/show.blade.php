@extends('layouts.app')

@section('title', $entry->title)

@section('content')
<div class="card">
    <a href="{{ route('entries.index') }}" style="color:#9e7b65; font-size:0.9rem;">← Înapoi la jurnal</a>
    <h2 style="color:#6b4f3a; margin:1rem 0 0.3rem;">{{ $entry->title }}</h2>
    <small style="color:#9e8878;">
        {{ $entry->created_at->format('d M Y, H:i') }}
        @if($entry->mood) &nbsp;·&nbsp; Stare: {{ ucfirst($entry->mood) }} @endif
    </small>
    <hr style="margin:1.2rem 0; border:none; border-top:1px solid #e8d9cc;">
    <p style="line-height:1.8; font-size:1rem; white-space:pre-wrap;">{{ $entry->content }}</p>
    <div style="margin-top:1.5rem; display:flex; gap:0.8rem;">
        <a href="{{ route('entries.edit', $entry) }}" class="btn btn-secondary">Editează</a>
        <form action="{{ route('entries.destroy', $entry) }}" method="POST"
              onsubmit="return confirm('Ștergi această intrare?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Șterge</button>
        </form>
    </div>
</div>
@endsection