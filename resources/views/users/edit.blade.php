@extends('layout')

  @section('title', "Crear usuario")

  @section('content')
    <h1>Editar usuario</h1>


    @if ($errors->any())
      <!--<p>Hay errores!</p>-->
      <div class="alert alert-danger">
        <h6>Por favor corrige los siguientes errores: </h6>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }} </li>
          @endforeach
        </ul>
      </div>
    @endif
    <hr>
    <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
      {{ method_field('PUT') }}
      {{ csrf_field() }}

      <label from="name">Nombre:</label>
      <input type="text" name="name" id="name" placeholder="Pedro Perez" value="{{ old('name', $user->name) }}">
      @if ($errors->has('name'))
        <pre>{{ $errors->first('name') }}</pre>
      @endif
      <br>
      <label from="email">Email:</label>
      <input type="email" name="email" id="email" placeholder="pedro@correo.cl" value="{{ old('email', $user->email) }}">
      @if ($errors->has('email'))
        <p>{{ $errors->first('email') }}</p>
      @endif
      <br>
      <label from="password">Contraseña:</label>
      <input type="password" name="password" id="password" placeholder="Mayor a 6 caracteres">


      <button type="submit">Crear usuario</button>
    </form>

    <p>
      <a href="{{ route('users') }}">Regresar</a>
    </p>
  @endsection
  @section('sidebar')
    @parent
    <h2>Barra Lateral Personalizada</h2>
  @endsection
