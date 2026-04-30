@extends('layouts.app')

@section('title', 'Editează intrarea')

@section('content')
<div style="max-width:640px; margin:0 auto;">
    <div class="card">
        <h2 style="color:#6b4f3a; margin-bottom:1.5rem;">Editează notita</h2>

        <form method="POST" action="{{ route('entries.update', $entry) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Titlu</label>
                <input type="text" name="title" value="{{ old('title', $entry->title) }}">
                @error('title') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Rândul pentru Mood și Tags -->
            <div class="row" style="display: flex; gap: 1.5rem; margin-bottom: 1rem;">
                
                <!-- Secțiunea Stare Sufletească -->
                <div style="flex: 1;">
                    <div class="form-group">
                        <label>Stare sufletească</label>
                        <select name="mood" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
                            <option value="">— Selectează —</option>
                            @foreach(['fericit','trist','neutru','energic','obosit'] as $mood)
                                <option value="{{ $mood }}" {{ old('mood', $entry->mood) == $mood ? 'selected' : '' }}>
                                    {{ ucfirst($mood) }}
                                </option>
                            @endforeach
                        </select>
                        @error('mood') <span class="error-msg" style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Secțiunea Tag-uri (Multi-select) -->
                <div style="flex: 1;">
                    <div class="form-group">
                        <label>Tag-uri</label>
                        <select name="tags[]" multiple style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc; min-height: 85px;">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" 
                                    {{ in_array($tag->id, old('tags', $entry->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        <small style="display: block; margin-top: 0.3rem; color: #666; font-size: 0.75rem;">
                            Ctrl + Click pentru selecție multiplă.
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Conținut</label>
                <textarea name="content" style="min-height: 150px;">{{ old('content', $entry->content) }}</textarea>
                @error('content') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="display:flex; gap:0.8rem;">
                <button type="submit" class="btn btn-primary">Actualizează</button>
                <a href="{{ route('entries.index') }}" class="btn btn-secondary">Anulează</a>
            </div>
        </form>
    </div>
</div>
@endsection