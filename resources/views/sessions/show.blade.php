@extends('layouts.app')

@section('content')
<div class="container mb-4" style="padding-top:70px;">
    <h1 class="mb-4">{{$session->title}}</h1>
    <div class="card mb-4">
        <div class="card-body">
            {!! Markdown::parse($session->content) !!}
        </div>
    </div>
    <div class="" style="margin:100px 0;">
        <h2 class="mb-4">Les professeurs concernés par cette session</h2>

        <table class="table table-striped mb-4">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Modalités du professeur</th>
                    <th scope="col">Gestion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->teachers as $key => $teacher)
                <tr>
                    <td>{{$teacher->name}}</td>
                    <td>{{$teacher->email}}</td>
                    <td>
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
                    </td>
                    <td>
                        <form action="/teachers/{{$teacher->id}}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger mb-2">supprimer ce professeur</button>
                        </form>
                        @if(count($teacher->modals) != 0)
                        <a href="{{action('ModalController@downloadPDF', $teacher->id)}}" class="btn btn-success">telecharger les modalité de {{$teacher->name}}</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr v-for="item in fakeList">
                    <td>@{{item.name}}</td>
                    <td>@{{item.email}}</td>
                    <td>
                        <p>ce professeur n'a pas encore remplit le formulaire</p>
                    </td>
                    <td>
                        <form :action="'/teachers/' + item.id" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger mb-2">supprimer ce professeur</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
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
                <input type="text"
                    name="name"
                    class="form-control"
                    list="teachers"
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
                    name="email"
                    class="form-control"
                    list="email"
                    id="title"
                    placeholder="l'email du prof ici"
                    autocomplete="off"
                    v-model="currentEmail"
                    @input="choice('email')">
                <datalist id="email">
                    <option v-for="teacher in teachers" :key="teacher.id" :teacher="teacher" :value="teacher.email" @click="choice(teacher)">
                </datalist>
            </div>
            <button type="submit" class="btn btn-primary" @click.prevent.stop="addTeacher()">ajouter le professeur</button>
        </form>
    </div>

</div>
@endsection
