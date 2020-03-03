@extends('layouts.app')

@section('content')
<div class="container show">
    <h1 class="show__title">{{$session->title}}</h1>
    <div class="mail">
        {!! Markdown::parse($session->content) !!}
    </div>
    <section class="teachers">
        <h2 class="show__title">Les professeurs concernés par cette session</h2>
        <div class="cards">
            @foreach($session->teachers as $key => $teacher)
            <div class="card">
                <h3 class="card__title">{{$teacher->name}}</h3>
                <div class="card__infos">
                    <p>Modalités&nbsp;:
                        @if(count($teacher->modals) != 0)
                            <span>Ce professeur a remplit le formulaire</span>
                        @else
                            <span>ce professeur n'a pas remplit le formulaire</span>
                        @endif
                    </p>
                    <a href="mailto:{{$teacher->email}}" class="card__mail">{{$teacher->email}}</a>
                </div>
                <input type="checkbox" class="sr-only card__managment__input" id="<?= 'card__managment' . $teacher->id; ?>">
                 <label for="<?= 'card__managment' . $teacher->id; ?>" class="card__managment__label">
                        <div class="burger">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                 </label>
                <div class="card__managment">
                    @if(count($teacher->modals) != 0)
                        <a href="{{action('ModalController@downloadPDF', $teacher->id)}}" class="btn btn-success">telecharger les modalité de {{$teacher->name}}</a>
                    @endif
                    <form action="/teachers/{{$teacher->id}}" method="post" class="">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Supprimer ce professeur">
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
