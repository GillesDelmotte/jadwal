<body>
    <h1>{{$modal->name}} - {{$modal->teacher->name}}</h1>
    <div>
        groupe(s) : {{$modal->group}}
    </div>
    <div>
        infos sur le(s) groupe(s): {{$modal->group_infos}}
    </div>
    <div>
        type d'évaluation : {{$modal->type}}
    </div>
    <div>
        local : {{$modal->local}}
    </div>
    <div>
        profs superviseur : {{$modal->supervisor}}
    </div>
</body>