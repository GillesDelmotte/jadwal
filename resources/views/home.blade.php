@extends('layouts.app')

@section('content')
<div class="container home">
    <h1 class="home__title">Vos sessions</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    @if($sessions->isNotEmpty())
    <div class="cards">
        @foreach($sessions as $session)
            <div class="card">
                <?php // calculate nbr of teachers's responses
                    $nbr = 0;
                    foreach($session->teachers as $teacher){
                        if($teacher->pivot->send == 1){
                            $nbr = $nbr + 1;
                        }
                    }
                ?>
                 <h2 class="card__title"><a href="/sessions/{{$session->id}}">{{$session->title}}</a></h2>
                 <div class="card__infos">
                     <p>Date de l'échéance : <span>{{$session->date->isoFormat('D MMM YYYY')}}</span></p>
                     <p>Nombre de prof ayant répondu : <span>{{ $nbr . ' / ' . count($session->teachers)}}</span></p>
                 </div>
                 <input type="checkbox" class="sr-only card__managment__input" id="<?= 'card__managment' . $session->id; ?>">
                 <label for="<?= 'card__managment' . $session->id; ?>" class="card__managment__label">
                        <div class="burger">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                 </label>
                <div class="card__managment">
                    <a href="/sessions/create?from={{$session->id}}" class="">Repartir de cette session</a>
                <form action="/sessions/{{$session->id}}" method="post" class="">
                    @csrf
                    @method('PUT')
                    <input type="submit" value="Archiver la session">
                </form>
                <form action="/sessions/{{$session->id}}" method="post" class="">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Supprimer la session">
                </form>
                </div>
            </div>
        @endforeach

    </div>

    @else
    <div>
        <p>Vous n'avez pas de session en cours</p>
        <a href="/sessions/create" class="btn btn-primary">Creer une session</a>
    </div>
    @endif
</div>
@endsection
