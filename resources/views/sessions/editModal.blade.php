@extends('layouts.app2')

@section('content')
<div class="container" style='padding-top: 50px;'>
    <h1>
    Édition de "{{$modal->name}}"
    </h1>
     <form action="/modals/{{$modal->id}}" method="post">
        @csrf
        @method('put')
        <input type="hidden" name="token" value="{{$token}}">
        <div class="mb-3">
            @if($modal->type == 'oral')
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="examType" id="inlineRadio1" value="oral" checked>
                <label class="form-check-label" for="inlineRadio1">oral</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="examType" id="inlineRadio2" value="ecrit" >
                <label class="form-check-label" for="inlineRadio2">écrit</label>
            </div>
            @else
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="examType" id="inlineRadio1" value="oral">
                <label class="form-check-label" for="inlineRadio1">oral</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="examType" id="inlineRadio2" value="ecrit" checked>
                <label class="form-check-label" for="inlineRadio2">écrit</label>
            </div>
            @endif
        </div>
        <div class="form-group">
            <label for="courseName">Intitulé EXACT du cours</label>
            <input type="text" class="form-control" id="courseName" name="name" placeholder="Le nom du cours ici" value="{{$modal->name}}">
        </div>
        <div class="form-group">
            <label for="group">Groupe (Liste complète des groupe concernés)</label>
            <input type="text" class="form-control" id="group" name="group" placeholder="le(s) groupe(s) ici" value="{{$modal->group}}">
        </div>
        <div class="form-group">
            <label for="groupInfos">Information supplémentaire sur les groupes</label>
            <textarea class="form-control" id="groupInfos" name="groupInfos" rows="6">{{$modal->group_infos}}</textarea>
            <small class="form-text text-muted">Un examen par groupe ? Un seul examen pour tous ? Tous les groupe en même temps ?</small>
        </div>
        <div class="form-group">
            <label for="duration">Durée de l'examen</label>
            <select class="form-control" id="duration" name="duration" value="old('duration')">
                <option>1 heure</option>
                <option>2 heures</option>
                <option>3 heures</option>
                <option>4 heures</option>
                <option>La journée</option>
            </select>
        </div>
        <div class="form-group">
            <label for="local">Locaux possibles</label>
            <input type="text" class="form-control" id="local" name="local" placeholder="Le(s) local ici" value="{{$modal->local}}">
        </div>
        <div class="form-group">
            <label for="supervisor">Surveillants souhaités</label>
            <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Le(s) surveillant(s) ici" value="{{$modal->supervisor}}">
        </div>
        <div class="form-group">
            <label for="moreInfos">Demandes particuliaires / indisponibilités / contraintes</label>
            <textarea class="form-control" id="groupInfos" name="moreInfos" rows="6">{{$modal->more_infos}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">mettre à jour ce cours</button>
        <a href="/sessions/fillModals/{{$token}}" class="btn btn-danger ml-2">annuler</a>
    </form>
</div>
@endsection
