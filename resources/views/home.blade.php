@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    <h1>Vos sessions</h1>
    <ul class="list-group">
        @foreach($sessions as $session)
        <li class="list-group-item">
            <div class="d-flex justify-content-between">
                <h2 class="text-primary">
                    {{$session->title}}
                </h2>
                <div>
                    {{$session->date->toDateString()}}
                </div>
            </div>
            <a href="/sessions/{{$session->id}}" class="btn btn-primary">consulter la session</a>
        </li>
        @endforeach
    </ul>
</div>
@endsection