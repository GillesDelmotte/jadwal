@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$session->title}}</h1>
    <p>
        {{$session->content}}
    </p>
    <div>
        <h2>Les professeurs concernés par cette session</h2>
        <ul class="list-group">
            @foreach($session->teachers as $teacher)
            <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    {{$teacher->teacher->name}}
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection