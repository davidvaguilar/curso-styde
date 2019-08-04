<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function index(){
    /*if( request()->has('empty') ){
      $users = [];
    } else {
      $users = [
        'Joel',
        'Ellie',
        'Tess',
        'Tommy',
        'Bill',
        '<script>alert("Clicker")</script>'
      ];    }*/

    //$users = DB::table('users')->get();
    $users = User::all();

    //dd($users);

  /*  return view('users', [
      'users' => $users,
      'title' => 'Listado de usuarios'
    ]);*/
/*    return view('users')->with([
      'users' => $users,
      'title' => 'Listado de usuarios'
    ]);*/
  /*  return view('users')
        ->with('users', $users)
        ->with('title', 'Listado de usuarios');*/
    $title = 'Listado de usuarios';
  //  dd(compact('title', 'users'));
    return view('users.index', compact('title', 'users'));
  }

  public function show(User $user){
  //public function show($id){
     // $user = User::findOrFail($id);
    // exit('Linea no alcanzada');

  /*  $user = User::find($id);
    if($user == null){
      return response()->view('errors.404', [], 404);
    }*/
    //dd($user);
    return view('users.show', compact('user'));
    //return view('users.show', compact('id'));
    // return "Mostrando detalle del usuario: {$id}. ";
  }

  public function create(){
    return view('users.create');
    //return "Crear nuevo usuario";
  }

  public function store(){
  //  $data = request()->all();
    //return redirect('usuarios/nuevo')->withInput();
    $data = request()->validate([
      'name' => 'required',
      //'email' => 'required|email',
      'email' => ['required','email', 'unique:users,email'],
      'password' => ['required','between:6,14'],
    ], [
      'name.required' => 'El campo nombre es obligatorio'
    ]);

  /*  if(empty($data['name'])){
      return redirect('usuarios/nuevo')->withErrors([
        'name' => 'El campo es obligatorio',
      ]);
    }*/
    // $data = request()->only(['name','email', 'password']);
    User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
    ]);

    //return "Procesando Informacion";
    //return redirect('usuarios');
    return redirect()->route('users');
  }

  public function edit(User $user){
    return view('users.edit', ['user' => $user]);
  }

  public function update(User $user){
    //return redirect("usuarios/{$user->id}");
    //dd("actualizar usuario");
    $data = request()->validate([
      'name' => 'required',
      // 'email' => 'required|email|unique:users,email,'.$user->id,
      'email' => [
          'required',
          'email',
          Rule::unique('users', 'email')->ignore($user->id)
      ],
      'password' => '',  //['required','between:6,14']
    ]);

    if($data['password'] != null){
      $data['password'] = bcrypt($data['password']);
    } else {
      unset($data['password']);
    }

    //$data['password'] = bcrypt($data['password']);
    $user->update($data);
    return redirect()->route('users.show', ['user' => $user]);
  }

  public function destroy(User $user){
    // return redirect('usuarios')
    $user->delete();
    return redirect()->route('users');
  }
}
