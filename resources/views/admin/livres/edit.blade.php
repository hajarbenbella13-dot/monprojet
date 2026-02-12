@extends('layouts.app')

@section('content')
<h1>Modifier livre</h1>

<form action="{{ route('livres.update', $livre->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Titre:</label>
    <input type="text" name="titre" value="{{ $livre->titre }}" required><br><br>

    <label>Description:</label>
    <textarea name="description">{{ $livre->description }}</textarea><br><br>

    <label>Age Min:</label>
    <input type="number" name="ageMin" value="{{ $livre->ageMin }}"><br><br>

    <label>Age Max:</label>
    <input type="number" name="ageMax" value="{{ $livre->ageMax }}"><br><br>

    <label>Photo:</label>
    <input type="file" name="photo"><br>
    @if($livre->photo)
        <img src="{{ asset('uploads/'.$livre->photo) }}" width="50">
    @endif
    <br><br>

    <button type="submit">Modifier</button>
</form>
@endsection
