@extends('layout')

  @section('title', "Usuario {$user->id}")

  @section('content')
    <h1>Usuario #{{ $user->id }}</h1>
    <hr>
    <!--Mostrando detalle del usuario: {{ $user->id }}-->
    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Correo Electronico: {{ $user->email }}</p>

    <p>
      <a href="{{ url('/usuarios') }}">Regresar</a>
      <a href="{{ url()->previous() }}">Regresar</a>
      <a href="{{ action('UserController@index') }}">Regresar al listado de usuarios</a>
      <a href="{{ route('users') }}">Regresar</a>
    </p>
  @endsection
  @section('sidebar')
    @parent
    <h2>Barra Lateral Personalizada</h2>
  @endsection
