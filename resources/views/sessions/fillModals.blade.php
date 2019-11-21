@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Remplir mon/mes horaire(s)</h1>

    <h2>{{$session->title}}</h2>

    <form action="/modals" method="post">
        @csrf
        <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="examType" id="inlineRadio1" value="oral">
                <label class="form-check-label" for="inlineRadio1">oral</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="examType" id="inlineRadio2" value="ecrit" checked>
                <label class="form-check-label" for="inlineRadio2">écrit</label>
            </div>
        </div>
        <div class="form-group">
            <label for="courseName">Intitulé EXACT du cours</label>
            <input type="text" class="form-control" id="courseName" name="name" placeholder="Le nom du cours ici">
        </div>
        <div class="form-group">
            <label for="group">Groupe (Liste complète des groupe concernés)</label>
            <input type="text" class="form-control" id="group" name="group" placeholder="le(s) groupe(s) ici">
        </div>
        <div class="form-group">
            <label for="groupInfos">Information supplémentaire pour les groupes</label>
            <textarea class="form-control" id="groupInfos" name="groupInfos" rows="6"></textarea>
            <small class="form-text text-muted">Un examen par groupe ? Un seul examen pour tous ? Tous les groupe en même temps ?</small>
        </div>
        <div class="form-group">
            <label for="local">Locaux possibles</label>
            <input type="text" class="form-control" id="local" name="local" placeholder="Le(s) local ici">
        </div>
        <div class="form-group">
            <label for="supervisor">Surveillants souhaités</label>
            <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Le(s) surveillant(s) ici">
        </div>
        <button type="submit" class="btn btn-primary">sauvegarder ce cours</button>
    </form>

</div>
@endsection