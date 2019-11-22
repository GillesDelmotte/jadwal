@extends('layouts.app')

@section('content')
<div class="container create">
    <h1>creation d'une nouvelle session</h1>
    <div>
        <h2>repartir d'une ancienne session</h2>
        <ul>
            @foreach($sessions as $session)
            <li>
                <a href="/sessions/create?from={{$session->id}}">{{$session->title}}</a>
            </li>
            @endforeach
        </ul>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/sessions" method="POST">
        @csrf
        <input type="hidden" name="lastSession" value="{{$lastSession ? $lastSession->id : ''}}">
        <div class="form-group">
            <label for="title">Titre de votre session</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Le titre de votre session ici">
        </div>
        <div class="form-group">
            <label for="title">Date de l'écheance</label>
            <input type="date" name="date" class="form-control" id="title" placeholder="Le titre de votre session ici">
        </div>
        <div class="form-group">
            <label for="content">Le contenu de votre mail</label>
            <textarea class="form-control" id="content" name="content" rows="6">{{$lastSession ? $lastSession->content : ''}}</textarea>
            <small class="form-text text-muted">#titre ##sous-titre **gras** *italic* ***gras+italic*** [intitulé du lien](le lien)</small>
        </div>
        <button type="submit" class="btn btn-primary">suivant</button>
    </form>
</div>
@endsection