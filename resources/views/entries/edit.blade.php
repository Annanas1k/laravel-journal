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

            <div class="form-group">
                <label>Stare sufletească</label>
                <select name="mood">
                    <option value="">— Selectează —</option>
                    @foreach(['fericit','trist','neutru','energic','obosit'] as $mood)
                        <option value="{{ $mood }}" {{ old('mood', $entry->mood) == $mood ? 'selected' : '' }}>
                            {{ ucfirst($mood) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Conținut</label>
                <textarea name="content">{{ old('content', $entry->content) }}</textarea>
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