@extends('layouts.app')

@section('content')
<div class="container create">

    <h1>{{$session->title}}</h1>
    <p>
        {{$session->content}}
    </p>

    <div>
        <h2>ajouter des profs a cette session</h2>

        <form action="/teachers" method="post" class="mb-4">
            @csrf
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
</div>
@endsection