@extends('layouts.app')

@section('content')
<div class="container-fluid create__teacher mb-4">

    <h1 class="mb-4">{{$session->title}}</h1>
    <div class="card mb-4">
        <div class="card-body">
            {!! Markdown::parse($session->content) !!}
        </div>
    </div>

    <div class="mb-4">
        <div class="choice">
            <div>
                <h2>ajouter des destinataires via un csv</h2>

                <form action="/csv" method="post" class="mb-4" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">importer un fichier CSV</label>
                        <input type="file" accept=".csv" name="file" class="form-control-file" id="title" placeholder="le nom et prenom du prof ici">
                        <small class="form-text text-muted">Votre fichier csv doit comporté une colonne 'nom' et une colonne 'email'</small>
                    </div>
                    <button type="submit" class="btn btn-primary">importer le fichier</button>
                </form>
            </div>
            <div>
                <h2>ajouter des destinataires via un formulaire</h2>
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
                    <div class="form-group">
                        <label for="name">Nom et prénom du professeur</label>
                        <input type="text"
                             list="teachers"
                             name="name"
                             class="form-control"
                             id="title"
                             placeholder="le nom et prenom du prof ici"
                             v-model="currentTeacher"
                             autocomplete="off"
                             @input="choice('teacher')">
                        <datalist id="teachers">
                            <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.name">
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="email">Email du professeur</label>
                        <input type="email"
                                list="email"
                                name="email"
                                class="form-control"
                                id="title"
                                placeholder="l'email du prof ici"
                                autocomplete="off"
                                v-model="currentEmail"
                                @input="choice('email')">
                        <datalist id="email">
                            <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.email" @click="choice(teacher)">
                        </datalist>
                    </div>
                    <button type="submit" class="btn btn-primary" @click="addTeacher($event)">ajouter le professeur</button>
                </form>
            </div>
        </div>



        <h2 class="mb-4">La liste des professeurs</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gestion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->teachers as $key => $teacher)
                <tr>
                    <th scope="row">{{$key + 1}}</th>
                    <td>{{$teacher->name}}</td>
                    <td>{{$teacher->email}}</td>
                    <td>
                        <form action="/teachers/{{$teacher->id}}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">supprimer ce professeur</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="/sessions/sendEmails" method="post">
        @csrf
        <button type="submit" class="btn btn-primary">envoyer les emails</button>
    </form>
</div>
@endsection
