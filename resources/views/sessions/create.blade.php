@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="main-title">Creer une session</h1>
    <div class="aside">
        <h2 class="aside__title">repartir d'un ancien email</h2>
        <p class="aside__explanation">
            en repartant d'un ancien email, vous récupérez l'email et tous les destinataires
        </p>
        @if($sessions->isNotEmpty())
        <ul class="list">
            @foreach($sessions as $session)
            <li class="list__item">
                <a href="/sessions/create?from={{$session->id}}">{{$session->title}}</a>
            </li>
            @endforeach
        </ul>
        @else
            <p class="aside__alert">Vous n'avez pas encore enregistrer de mail</p>
        @endif
    </div>
    <div class="create__session">
        <h1 class="create__title">création d'un nouvel email</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="/sessions" method="POST" class="form">
            @csrf
            <div class="form__container">
                <input type="hidden" name="lastSession" value="{{$lastSession ? $lastSession->id : ''}}">
                <div class="form-group">
                    <label for="title">Titre de votre session</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Session Juin 2020 Infographie" value="{{old('title')}}">
                </div>
                <div class="form-group">
                    <label for="date">Date de l'écheance</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{old('date')}}">
                </div>
                <div class="form-group">
                    <label for="content">Le contenu de votre mail</label>
                    <textarea class="form-control" id="content" name="content" rows="6">{{old('content') ? old('content') : ($lastSession ? $lastSession->content : '')}}</textarea>
                    <small class="form-text text-muted">#titre ##sous-titre **gras** *italic* ***gras+italic*** [intitulé du lien](le lien)</small>
                </div>
            </div>
            <div class="form__button-save">
                <button type="submit" class="sendButton ">suivant</button>
                @if(count($sessions) < 10)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="save" id="save" class="ml-3 mr-2"> <label for="save">sauvegarder cet email</label>
                    </div>
                @endif
            </div>

        </form>
    </div>
</div>

@endsection
