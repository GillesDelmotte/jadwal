@extends('layouts.app2')

@section('content')
<div class="aside">
    <h4>repartir d'une ancienne modalité</h4>
    <p>
        En repartant d'une ancienne modalité, les champs du formulaire seront pré-remplis avec les valeurs de cette modalité
    </p>
    <ul>
        @foreach($modals as $modal)
        <li><a href="{{url()->current() .'?from=' . $modal->id}}">{{$modal->name}}</a></li>
        @endforeach
    </ul>
</div>
<div class="create__session">
    <h1>Remplir mon/mes horaire(s) - {{$session->title}}</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
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
            <input type="text" class="form-control" id="courseName" name="name" placeholder="Le nom du cours ici" value="{{old('courseName') ? old('courseName') : ($lastModal ? $lastModal->name : '')}}">
        </div>
        <div class="form-group">
            <label for="group">Groupe (Liste complète des groupe concernés)</label>
            <input type="text" class="form-control" id="group" name="group" placeholder="le(s) groupe(s) ici" value="{{old('group') ? old('group') : ($lastModal? $lastModal->group : '')}}">
        </div>
        <div class="form-group">
            <label for="groupInfos">Information supplémentaire sur les groupes</label>
            <textarea class="form-control" id="groupInfos" name="groupInfos" rows="6">{{old('group_infos') ? old('group_infos') : ($lastModal? $lastModal->group_infos : '')}}</textarea>
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
            <input type="text" class="form-control" id="local" name="local" placeholder="Le(s) local ici" value="{{$lastModal? $lastModal->local : ''}}">
        </div>
        <div class="form-group">
            <label for="supervisor">Surveillants souhaités</label>
            <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Le(s) surveillant(s) ici" value="{{old('supervisor') ? old('supervisor') : ($lastModal? $lastModal->supervisor : '')}}">
        </div>

        <div class="form-group">
            <label for="moreInfos">Demandes particuliaires / indisponibilités / contraintes</label>
            <textarea class="form-control" id="groupInfos" name="moreInfos" rows="6">{{old('more_infos') ? old('more_infos') : ($lastModal? $lastModal->more_infos : '')}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">sauvegarder ce cours</button>
    </form>

</div>
@endsection