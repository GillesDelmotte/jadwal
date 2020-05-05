@extends('layouts.app2')

@section('content')
<div class="container home">
    <h1 class="main-title--second">
        @if($toto)
            Remplir mon/mes horaire(s) -
        @endif
        {{$session->title}}
    </h1>
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
    <section class="aside">
        @if($toto && count($teacher->modalsForTeacher) != 0)
        <form action="/sendModals/{{$teacher->id}}/{{$session->id}}" method="post" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="sendButton" >Envoyer mes modalités</button>
        </form>
        @endif
        @if($toto)
            <h2 class="aside__title">repartir d'une ancienne modalité</h2>
            <p class="aside__explanation">
                En repartant d'une ancienne modalité, les champs du formulaire seront pré-remplis avec les valeurs de cette modalité
            </p>
            @if($modals->isNotEmpty())
                <ul class="list">
                    @foreach($modals as $modal)
                    <li class="list__item"><a href="{{url()->current() .'?from=' . $modal->id}}">{{$modal->name}}</a></li>
                    @endforeach
                </ul>
            @else
                <p class="aside__alert">Vous n'avez pas encore enregistrer de modalitée</p>
            @endif
        @else
        <p class="aside__explanation">
            merci d'avoir remplis vos modalités. pour toute erreur ou modification, veillez contacter l'horairiste
        </p>
        <a href="{{action('ModalController@downloadPDF', $teacher->id)}}" class="sendButton--link" style="margin-bottom: 30px;" target="_blank">Télécharger le pdf</a>
        @endif
    </section>
    <section class="create__session">
         @if(session('success'))
        <div class="alert-success">
            {{session('success')}}
        </div>
        @endif
        @if(count($teacher->modalsForTeacher) != 0)
            <div class="cards">
                @foreach($teacher->modalsForTeacher as $modal)
                <div class="table card">
                    <h3 class="table__title">{{$modal->name}}</h3>
                    <div class="table__content">
                        <span class="table__group">{{$modal->group}}</span>
                        <span class="table__duration">{{$modal->duration}}</span>
                        <span class="table__local">{{$modal->local}}</span>
                        <span class="table__supervisor">{{$modal->supervisor}}</span>
                    </div>
                    @if($toto && count($teacher->modalsForTeacher) != 0)
                    <input type="checkbox" class="sr-only card__managment__input" id="<?= 'card__managment' . $modal->id; ?>">
                    <label for="<?= 'card__managment' . $modal->id; ?>" class="card__managment__label">
                    <div class="burger">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    </label>
                    <div class="card__managment">
                    <a href="/sessions/{{$modal->id}}/editModal/{{$token}}" class="">éditer cette modalitée</a>
                    <form action="/modals/{{$modal->id}}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="submit" class="" value="supprimer cette modalitée">
                    </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif

        @if($toto)
            <form action="/modals" method="post">
                @csrf
                <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                <div class="form__checkbox">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="examType" id="inlineRadio1" value="oral">
                        <label class="form-check-label" for="inlineRadio1">oral</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="examType" id="inlineRadio2" value="ecrit" checked>
                        <label class="form-check-label" for="inlineRadio2">écrit</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="courseName">Intitulé EXACT du cours</label>
                    <input type="text" class="form-control" id="courseName" name="name" placeholder="Le nom du cours ici" value="{{old('courseName') ? old('courseName') : ($lastModal ? $lastModal->name : '')}}">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Intitulé du cours" est obligatoire</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="group">Groupe (Liste complète des groupe concernés)</label>
                    <input type="text" class="form-control" id="group" name="group" placeholder="le(s) groupe(s) ici" value="{{old('group') ? old('group') : ($lastModal? $lastModal->group : '')}}">
                    @if ($errors->has('group'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Groupe" est obligatoire</strong>
                        </span>
                    @endif
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
                    @if ($errors->has('local'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "Locaux possibles" est obligatoire</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="supervisor">Surveillants souhaités</label>
                    <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Le(s) surveillant(s) ici" value="{{old('supervisor') ? old('supervisor') : ($lastModal? $lastModal->supervisor : '')}}">
                    @if ($errors->has('supervisor'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Le champs "surveillants" est obligatoire</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="moreInfos">Demandes particuliaires / indisponibilités / contraintes</label>
                    <textarea class="form-control" id="groupInfos" name="moreInfos" rows="6">{{old('more_infos') ? old('more_infos') : ($lastModal? $lastModal->more_infos : '')}}</textarea>
                </div>
                <div class="form__button-save">
                    <button type="submit" class="sendButton">sauvegarder ce cours</button>
                    @if(count($modals) < 5)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="save" id="save" class="ml-3 mr-2"> <label for="save">sauvegarder ma modalité</label>
                    </div>
                    @endif
                </div>
            </form>
        @endif
    </section>

</div>

@endsection
