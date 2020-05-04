@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="main-title">Inscription</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="form">
                        @csrf
                        <div class="form__container">
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>
                                <input id="name" type="text" placeholder="Jean Charles" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Adresse e-mail</label>
                                <input id="email" placeholder="jean.charles@gmail.com"type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Mot de passe</label>
                                <input id="password" placeholder="Minimum 8 caractères" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmation du mot de passe</label>
                                <input id="password-confirm" placeholder="Minimum 8 caractères" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="sendButton">
                            Inscription
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
