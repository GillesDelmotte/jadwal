@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Vos sessions archivées</h1>
    @if($sessions->isNotEmpty())
    @foreach($sessions as $session)
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">{{$session->title}}</h3>
            <p class="card-text">
                <span>Date de l'échéance : {{$session->date->isoFormat('D MMM YYYY')}}</span> - <span>Date de création : {{$session->created_at->isoFormat('D MMM YYYY')}}</span>
            </p>
            <div class="d-flex justify-content-start">
                <a href="/sessions/{{$session->id}}" class="btn btn-primary mr-2">Consulter la session</a>
                <form action="/sessions/{{$session->id}}" method="post" class="mr-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer la session</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div>
        <p>Vous n'avez pas de session archivées</p>
    </div>
    @endif
</div>
@endsection