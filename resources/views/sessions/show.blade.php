@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$session->title}}</h1>
    <div class="card mb-4">
        <div class="card-body">
            {!! Markdown::parse($session->content) !!}
        </div>
    </div>
    <div class="mb-4">
        <h2>Les professeurs concernés par cette session</h2>
        <ul class="list-group mb-3">
            @foreach($session->teachers as $teacher)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h3>
                        horaire(s) de {{$teacher->name}}
                    </h3>
                    @if(count($teacher->modals) != 0)
                    <ul>
                        @foreach($teacher->modals as $modal)
                        <li>
                            {{$modal->name}}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>ce professeur n'a pas encore remplit le formulaire</p>
                    @endif
                </div>
                <div>
                    <form action="/teachers/{{$teacher->id}}" method="post" class="text-right mb-2">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">supprimer ce professeur</button>
                    </form>
                    @if(count($teacher->modals) != 0)
                    <a href="{{action('ModalController@downloadPDF', $teacher->id)}}" class="btn btn-success">telecharger les modalité de {{$teacher->name}}</a>
                    @endif
                </div>

            </li>
            @endforeach
        </ul>
        <form action="/sessions/sendEmails" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">renvoyer les emails aux professeurs qui n'ont pas remplis leur formulaire</button>
        </form>
    </div>
    <div>
        <h2>Ajouter de nouveau professeur a cette session</h2>

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
    </div>

</div>
@endsection