<style>
    * {
        border-collapse: collapse;
    }

    .table {
        width: 100%;
    }

    .table thead {
        background-color: rgba(200, 200, 200, 0.5);
    }

    th {
        background-color: rgba(200, 200, 200, 0.5);
        padding: 5px 10px;
    }

    td {
        padding: 5px 10px;
    }
</style>

<body>
    <h1 class="titre">
        {{$session->title}} - {{$teacher->name}}
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom du cours</th>
                <th scope="col">groupe</th>
                <th scope="col">type d'examen</th>
                <th scope="col">durée de l'examen</th>
                <th scope="col">local</th>
                <th scope="col">surveillant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teacher->modals as $key => $modal)
            <tr>
                <th scope="row">{{$key + 1}}</th>
                <td>{{$modal->name}}</td>
                <td>{{$modal->group}}</td>
                <td>{{$modal->type}}</td>
                <td>{{$modal->duration}}</td>
                <td>{{$modal->local}}</td>
                <td>{{$modal->supervisor}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>recommandation pour les groupes</h2>

    @foreach($teacher->modals as $key => $modal)
    <p>
        {{$key + 1}} . {{$modal->group_infos ? $modal->group_infos : '/'}}
    </p>
    @endforeach

    <h2>Demandes particuliaires / indisponibilités / contraintes</h2>

    @foreach($teacher->modals as $key => $modal)
    <p>
        {{$key + 1}} . {{$modal->more_infos ? $modal->more_infos : '/'}}
    </p>
    @endforeach
</body>