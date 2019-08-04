@extends('layout')

  @section('title', "Usuarios")
  @section('content')
    <h1>{{ $title }}</h1>
    <hr>
    <p>
      <a href="{{ route('users.create') }}">Nuevo Usuario</a>
    </p>
  <!--  @unless( empty($users) )
      <ul>
        @foreach ($users as $user)
          <li>{{ $user->name }}, ({{ $user->email }})</li>
        @endforeach
      </ul>
    @else
      <p>No hay usuarios Registrados</p>
    @endunless-->

    <ul>
      @forelse ($users as $user)
        <li>
          {{ $user->name }}, ({{ $user->email }})
        <!--  <a href="{{ url('/usuarios/'.$user->id) }}">Ver detalles<a>
          <a href="{{ url("/usuarios/{$user->id}") }}">Ver detalles<a>
          <a href="{{ action('UserController@show', ['id'=> $user->id]) }}">Ver detalles<a> -->
          <a href="{{ route('users.show', ['id'=> $user->id]) }}">Ver detalles<a> |
          <a href="{{ route('users.edit', ['id'=> $user]) }}">Editar</a> |
          <form action="{{ route('users.destroy', $user) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit">Eliminar</button>
          </form>
        </li>
      @empty
        <li>No hay usuarios registrados</li>
      @endforelse
    </ul>
    <hr>
    {{ time() }}
  @endsection
  @section('sidebar')
    @parent
    <h2>Barra Lateral Personalizada</h2>
  @endsection
