@extends('layouts.app2')

@section('content')
<div class="aside">
    @if($toto && count($teacher->modalsForTeacher) != 0)
    <form action="/sendModals/{{$teacher->id}}/{{$session->id}}" method="post" class="mb-2">
        @csrf
        <button type="submit" class="btn btn-primary" >Envoyer mes modalités</button>
    </form>
    @endif
    @if(!$toto)
    <a href="{{action('ModalController@downloadPDF', $teacher->id)}}" class="btn btn-secondary" style="margin-bottom: 30px;" target="_blank">Télécharger le pdf</a>
    @endif
    @if($toto)
    <h4>repartir d'une ancienne modalité</h4>
    <p>
        En repartant d'une ancienne modalité, les champs du formulaire seront pré-remplis avec les valeurs de cette modalité
    </p>
    <ul>
        @foreach($modals as $modal)
        <li><a href="{{url()->current() .'?from=' . $modal->id}}">{{$modal->name}}</a></li>
        @endforeach
    </ul>
    @endif
</div>
<div class="create__session">
    <h1>
        @if($toto)
            Remplir mon/mes horaire(s) -
        @endif
        {{$session->title}}
    </h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#exampleModalCenter">
       Afficher l'email
    </button>
    @if(count($teacher->modalsForTeacher) != 0)
        <div class="mt-4 mb-4">
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Cours</th>
            <th scope="col">Groupes</th>
            <th scope="col">Durée</th>
            <th scope="col">Locaux</th>
            <th scope="col">Surveillants</th>
            @if($toto)
            <th scope="col">Gestion</th>
            @endif
            </tr>
        </thead>
        <tbody>
            @foreach($teacher->modalsForTeacher as $modal)
                <tr>
                <td>{{$modal->name}}</td>
                <td>{{$modal->group}}</td>
                <td>{{$modal->duration}}</td>
                <td>{{$modal->local}}</td>
                <td>{{$modal->supervisor}}</td>
                @if($toto)
                <td>
                    <form action="/modals/{{$modal->id}}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger mb-2">supprimer</button>
                    </form>
                    <a href="/sessions/{{$modal->id}}/editModal/{{$token}}" class="btn btn-warning mb-2">éditer</a>
                </td>
                @endif
                </tr>
            @endforeach
        </tbody>
        </table>
        </div>
    @endif
    @if($toto)
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
        @if(count($modals) < 5)
        <div class="form-check form-check-inline">
            <input type="checkbox" name="save" id="save" class="ml-3 mr-2"> <label for="save">sauvegarder ma modalité</label>
        </div>
        @endif
    </form>
    @else
    <div>
        merci d'avoir remplis vos modalités. pour toute erreur ou modification, veillez contacter l'horairiste
    </div>
    @endif

</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Markdown::parse($session->content) !!}
      </div>
    </div>
  </div>
</div>
@endsection
