@component('mail::message')

{{$session->content}}
<br>
[remplir mon horaire]({{config('app.url')}}/sessions/fillModals/{{$token}})

@endcomponent