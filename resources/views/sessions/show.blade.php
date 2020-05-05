@extends('layouts.app')

@section('content')
<div class="container show">
    <h1 class="show__title">{{$session->title}}</h1>
    <div class="showmail">
        <input type="checkbox" name="showmail" id="showmail" class="sr-only showmail__checkbox">
        <label for="showmail" class="showmail__label">
            <span class="showmail__on">Afficher l'email de la session</span>
            <span class="showmail__off">Masquer l'email de la session</span>
            <span class="showmail__icon"></span>
        </label>
        <div class="mail">
            {!! Markdown::parse($session->content) !!}
        </div>
    </div>
    <section class="teachers">
        <h2 class="show__title">Les professeurs concernés par cette session</h2>

        <div class="cards">
            @if(count($session->teachers) !== 0)
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
                        <a href="{{action('ModalController@downloadPDF', $teacher->id)}}" class="btn btn-success">télécharger les modalité de {{$teacher->name}}</a>
                    @endif
                    <a href="/sessions/fillModals/<?= $teacher->pivot->token?>" target="_blank">Remplir les modalitées</a>
                    <form action="/teachers/{{$teacher->id}}" method="post" class="">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Supprimer ce professeur">
                    </form>
                </div>
            </div>
            @endforeach
            @else
            <div class="emptyCards">
                Vous n'avez ajouté aucun professeur a cette session. vous pouvez en ajouer via le formulaire ci-dessous. Quand vous avez terminer d'ajouter les professeur, n'oublier pas d'appuyer sur le bouton "envoyer les emails aux professeurs"
            </div>
            @endif
        </div>
    </section>
    @if(count($session->teachers) !== 0)
    <form action="/sessions/sendEmails" method="post">
        @csrf
        <button type="submit" class="sendButton">Renvoyer les emails aux professeurs</button>
    </form>
    @endif
    <section class="newTeacher">
        <h2 class="show__title">Ajouter de nouveau professeur a cette session</h2>
        @if ($errors->any())

        @endif
        <form action="/teachers" method="post" class="form">
            @csrf
            <input type="hidden" name="type" value="form">
            <div class="form__container">
                <div class="form-group">
                    <label for="name">Nom et prénom du professeur</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        list="teachers"
                        id="title"
                        placeholder="Annie schmidt"
                        v-model="currentTeacher"
                        autocomplete="off"
                        @input="choice('teacher')">
                    <datalist id="teachers">
                        <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.name">
                    </datalist>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Nom" est obligatoire</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email du professeur</label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        list="email"
                        id="title"
                        placeholder="annie.schmidt@example.lu"
                        autocomplete="off"
                        v-model="currentEmail"
                        @input="choice('email')">
                    <datalist id="email">
                        <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.email" @click="choice(teacher)">
                    </datalist>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Email" est obligatoire</strong>
                        </span>
                    @endif
                </div>
            </div>
            <button type="submit" class="form__button">Ajouter le professeur</button>
        </form>
    </section>
</div>
@endsection
