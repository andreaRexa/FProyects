@extends('layout')

@section('title', 'Iniciar sesión')

@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Iniciar Sesión</div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" class="form-control" name="Correo" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                    </div>
                </form>

                <div class="form-group">
                    <a href="{{ route('pass.olvidada') }}">¿Olvidaste tu contraseña?</a>
                </div>
                <div class="form-group">
                    <a href="{{ route('registroForm') }}">¿Aun no tienes cuenta?</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
