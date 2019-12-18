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
    .reco{
        margin: 10px 0;
    }
    .border{
        background-color: rgba(200, 200, 200, 0.5);
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
            <tr class="all">
            <th scope="row"></th>
            <td colspan="6">
                <div class="reco">
                    <b>recommandation pour les groupes :</b>  {{$modal->group_infos ? $modal->group_infos : '/'}}
                </div>
                <div class="reco">
                    <b>Demandes particuliaires / indisponibilités / contraintes :</b> {{$modal->more_infos ? $modal->more_infos : '/'}}
                </div>
            </td>
            </tr>
            <tr class="border">
            <td colspan="7" ></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
