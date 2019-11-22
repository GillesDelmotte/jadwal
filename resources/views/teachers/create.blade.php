@extends('layouts.app')

@section('content')
<div class="container create">

    <h1>{{$session->title}}</h1>
    <p>
        {{$session->content}}
    </p>

    <div class="mb-4">
        <h2>ajouter des profs a cette session</h2>

        <form action="/teachers" method="post" class="mb-4">
            @csrf
            <input type="hidden" name="type" value="csv">
            <div class="form-group">
                <label for="file">importer un fichier CSV</label>
                <input type="file" accept=".csv" name="file" class="form-control-file" id="title" placeholder="le nom et prenom du prof ici">
            </div>
            <button type="submit" class="btn btn-primary">importer le fichier</button>
        </form>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/teachers" method="post" class="mb-4">
            @csrf
            <input type="hidden" name="type" value="form">
            <div class="form-group ">
                <label for="name">Nom et prénom du professeur</label>
                <input type="text" name="name" class="form-control" id="title" placeholder="le nom et prenom du prof ici">
            </div>
            <div class="form-group">
                <label for="email">Email du professeur</label>
                <input type="email" name="email" class="form-control" id="title" placeholder="l'email du prof ici">
            </div>
            <button type="submit" class="btn btn-primary">ajouter le professeur</button>
        </form>

        <h2>La liste des professeur</h2>

        <ul class="list-group">
            @foreach($session->teachers as $teacher)
            <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    <p>
                        {{$teacher->teacher->name}}
                    </p>
                    <form action="/teachers/{{$teacher->id}}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">supprimer ce professeur</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <form action="/sessions/sendEmails" method="post">
        @csrf
        <button type="submit" class="btn btn-primary">envoyer les emails</button>
    </form>
</div>
@endsection