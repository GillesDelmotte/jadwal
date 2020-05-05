@extends('layouts.app')

@section('content')
<div class="container show">
    <h1 class="main-title">{{$session->title}}</h1>
    <div class="mail">
        {!! Markdown::parse($session->content) !!}
    </div>
    <section class="choice">
        <div>
            <h2 class="choice__title">ajouter des destinataires via un csv</h2>
            <a href="../canvasCsv.csv" class="downloadCsv"> télécharger le fichier csv type</a>
            <form action="/csv" method="post" class="mb-4" enctype="multipart/form-data" v-on:submit.prevent="refreshPage">
                @csrf
                <div class="form-group">
                    <label for="file" class="">importer un fichier CSV</label>
                    <div v-if="check">
                    <vue-dropzone  class="dropzone" ref="myVueDropzone" csrf="{{ csrf_token() }}" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
                    <small class="form-text text-muted">Votre fichier csv doit comporté une colonne 'nom' et une colonne 'email'</small>
                    </div>
                    <div v-else>
                        <input type="file" accept=".csv" name="file" class="" id="file" placeholder="le nom et prenom du prof ici">
                        <small class="form-text text-muted">Votre fichier csv doit comporté une colonne 'nom' et une colonne 'email'</small>
                    </div>
                </div>
                <button type="submit" class="sendButton">Envoyer le fichier</button>
            </form>
        </div>
        <div>
            <h2 class="choice__title">ajouter des destinataires via un formulaire</h2>
            <form action="/teachers" method="post" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="name">Nom et prénom du professeur</label>
                    <input type="text"
                            list="teachers"
                            name="name"
                            class="form-control"
                            id="name"
                            placeholder="Annie Schmidt"
                            v-model="currentTeacher"
                            autocomplete="off"
                            @input="choice('teacher')">
                    <datalist id="teachers">
                        <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.name" >
                    </datalist>
                    <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Nom" est obligatoire</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email du professeur</label>
                    <input type="email"
                            list="email"
                            name="email"
                            class="form-control"
                            id="email"
                            placeholder="annie.schmidt@example.lu"
                            autocomplete="off"
                            v-model="currentEmail"
                            @input="choice('email')">
                    <datalist id="email">
                        <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.email">
                    </datalist>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Email" est obligatoire</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="sendButton">Ajouter le professeur</button>
            </form>
        </div>
    </section>
    <section class="teachers">
        <h2 class="teachers__title">La liste des professeurs</h2>
        <div class="cards">
            @if(count($session->teachers) !== 0)
            @foreach($session->teachers as $key => $teacher)
                <div class="card">
                    <h3 class="card__title">{{$teacher->name}}</h3>
                    <div class="card__infos">
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
                Attention ! Vous n'avez sélectionné aucun professeur pour le moment. Si vous validez votre session maintenant, elle sera enregister mais aucun email ne sera envoyé. Cepandant, Vous pouvez toujours par la suite aller ajouter des professeurs via la page de la session.
            </div>
            @endif
        </div>
    </section>
    <form action="/sessions/sendEmails" method="post">
        @csrf
        <button type="submit" class="sendButton">envoyer les emails</button>
    </form>
</div>
@endsection
