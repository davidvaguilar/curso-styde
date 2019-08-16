@extends('layout')

  @section('title', "Crear usuario")

  @section('content')
    <div class="card">
      <h4 class="card-header">Crear nuevo usuario</h4>
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <h6>Por favor corrige los siguientes errores: </h6>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }} </li>
            @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ url('usuarios/crear') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label from="name">Nombre:</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Pedro Perez" value="{{ old('name') }}">
            @if ($errors->has('name'))
              <small id="nameHelp" class="form-text text-muted">{{ $errors->first('name') }}</small>
            @endif
          </div>
          <div class="form-group">
            <label from="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="pedro@correo.cl" value="{{ old('email') }}">
            @if ($errors->has('email'))
              <pre>{{ $errors->first('email') }}</pre>
            @endif
          </div>

          <div class="form-group">
            <label from="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Mayor a 6 caracteres">
          </div>

          <div class="form-group">
            <label for="bio">Bio:</label>
            <textarea name="bio" class="form-control" id="bio">{{ old('bio') }}</textarea>
          </div>
          <div class="form-group">
            <label from="twitter">Twitter:</label>
            <input type="text" name="twitter" id="twitter" class="form-control" placeholder="https://twitter.com/styde" value="{{ old('twitter') }}">
          </div>

          <button type="submit" class="btn btn-primary">Crear usuario</button>
          <a href="{{ route('users') }}" class="btn btn-link">Regresar al listado</a>
        </form>
      </div>
    </div>





  @endsection
  @section('sidebar')
    @parent
    <h2>Barra Lateral Personalizada</h2>
  @endsection
