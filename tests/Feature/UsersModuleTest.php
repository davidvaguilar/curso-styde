<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_default_message_if_the_users_list_is_empty()
    {
      //DB::table('users')->truncate();  //borrrar table
      $this->get('/usuarios')  //?empty
          ->assertStatus(200)
          ->assertSee('No hay usuarios registrados');
    }

    /** @test */
    public function it_shows_the_users_list()
    {
      factory(User::class)->create([
        'name' => 'Joel',
        'website' => 'thelast.com',
      ]);
      factory(User::class)->create([
        'name' => 'Ellie',
      ]);

      $this->get('/usuarios')
          ->assertStatus(200)
          ->assertSee('Listado de usuarios')
          ->assertSee('Joel')
          ->assertSee('Ellie');
    }

    /** @test */
  /*  public function it_loads_the_users_details_page()
    {
      $this->get('/usuarios/5')
          ->assertStatus(200)
          ->assertSee("Mostrando detalle del usuario: 5");
    }*/

    /** @test */
    public function it_displays_the_users_details()
    {
      $user = factory(User::class)->create([
        'name' => 'Duilio Palacios'
      ]);

      $this->get("/usuarios/{$user->id}") //usuarios/5
          ->assertStatus(200)
          ->assertSee("Duilio Palacios");
    }

    /** @test */
    public function it_displays_a_404_error_if_the_user_is_not_found()
    {
      $this->get('/usuarios/999')
          ->assertStatus(404)
          ->assertSee("Pagina no encontrada");
    }


    /** @test */
    public function it_loads_the_new_users_page()
    {
      //$this->withoutExceptionHandling();
      $this->get('/usuarios/nuevo')
          ->assertStatus(200)
          ->assertSee("Crear nuevo usuario");
    }

    /** @test */
    public function it_creates_a_new_user()
    {
      $this->withoutExceptionHandling();
      $this->post('/usuarios/crear', [
        'name' => 'David',
        'email' => 'fernando@styde.net',
        'password' => '123456',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/sillence',
      ])->assertRedirect('usuarios/');

      /*->assertRedirect(route('users.index'));*/

    /*  $this->assertDatabaseHas('users', [
        'name' => 'David',
        'email' => 'daniel@styde.net',
        'password' => '123456',
      ]);*/
      $this->assertCredentials([
        'name' => 'David',
        'email' => 'fernando@styde.net',
        'password' => '123456',
      ]);

      $this->assertDatabaseHas('user_profiles', [
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/sillence',
        'user_id' => User::findByEmail('fernando@styde.net')->id,
      ]);
    }

    /** @test */
    public function it_name_is_required()
    {
      DB::table('users')->truncate();
      //$this->withoutExceptionHandling();
      $this->from('usuarios/nuevo')
        ->post('/usuarios/crear', [
          'name' => '',
          'email' => 'fernandas@styde.net',
          'password' => '123456',
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

      $this->assertEquals(0, User::count());

      /*$this->assertDatabaseMissing('users', [
        'email' => 'fernanda@styde.net',
      ]);*/
    }

    /** @test */
    public function it_email_is_required()
    {
      //$this->withoutExceptionHandling();
      $this->from('usuarios/nuevo')
        ->post('/usuarios/crear', [
          'name' => 'Mara',
          'email' => '',
          'password' => '123456',
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

      $this->assertEquals(0, User::count());
    }

    /** @test */
    public function it_password_is_required()
    {
      //$this->withoutExceptionHandling();
      $this->from('usuarios/nuevo')
        ->post('/usuarios/crear', [
          'name' => 'Mara',
          'email' => 'mara@correlati.com',
          'password' => '',
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['password']);

      $this->assertEquals(0, User::count());
    }

    /** @test */
    public function it_email_must_be_valid()
    {
      //$this->withoutExceptionHandling();
      $this->from('usuarios/nuevo')
        ->post('/usuarios/crear', [
          'name' => 'Marcel',
          'email' => 'correo-no-valido',
          'password' => '123456',
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

      $this->assertEquals(0, User::count());
    }

    /** @test */
    public function it_email_must_be_unique()
    {
      //$this->withoutExceptionHandling();
      factory(User::class)->create([
        'email' => 'villegas@correo.com',
      ]);

      $this->from('usuarios/nuevo')
        ->post('/usuarios/crear', [
          'name' => 'Marcel',
          'email' => 'villegas@correo.com',
          'password' => '123456',
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

      $this->assertEquals(1, User::count());
    }

    /** @test */
    public function it_loads_the_edit_user_page()
    {
      //$this->withoutExceptionHandling();
      $user= factory(User::class)->create();

      $this->get("/usuarios/{$user->id}/editar")  //usuario/5/editar
        ->assertStatus(200)
        ->assertViewIs('users.edit')
        ->assertSee('Editar usuario')
        ->assertViewHas('user', function ($viewUser) use ($user){
          return $viewUser->id === $user->id;
      });

      /*->assertRedirect(route('users.index'));*/

    /*  $this->assertDatabaseHas('users', [
        'name' => 'David',
        'email' => 'daniel@styde.net',
        'password' => '123456',
      ]);*/
  /*    $this->assertCredentials([
        'name' => 'David',
        'email' => 'fernando@styde.net',
        'password' => '123456',
      ]);*/
    }

    /** @test */
    public function it_updates_a_user()
    {
      //$this->withoutExceptionHandling();
      $user= factory(User::class)->create();
      $this->put("/usuarios/{$user->id}", [
        'name' => 'David',
        'email' => 'fernando@styde.net',
        'password' => '123456',
      ])->assertRedirect("/usuarios/{$user->id}");

      $this->assertCredentials([
        'name' => 'David',
        'email' => 'fernando@styde.net',
        'password' => '123456',
      ]);
    }

    /** @test */
    public function the_name_is_required_when_updating_the_user()
    {
      DB::table('users')->truncate();
      $user = factory(User::class)->create();
      $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
          'name' => '',
          'email' => 'villegas@correo.com',
          'password' => '123456',
        ])
        ->assertRedirect("usuarios/{$user->id}/editar")
        ->assertSessionHasErrors(['name']);
      $this->assertDatabaseMissing('users', ['email' =>'villegas@correo.com']);
    }

    /** @test */
    public function it_email_must_be_valid_when_updating_the_user()
    {
      $user = factory(User::class)->create(['name' => 'Nombre inicial']);
      $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
          'name' => 'Moises',
          'email' => 'correo-no-valido',
          'password' => '123456',
        ])
        ->assertRedirect("usuarios/{$user->id}/editar")
        ->assertSessionHasErrors(['email']);
      $this->assertDatabaseMissing('users', ['name' => 'Moises']);
    }

    /** @test */
    public function the_email_must_be_unique_when_updating_the_user()
    {
      //self::markTestIncomplete();
      //return;
      //$this->withoutExceptionHandling();
      DB::table('users')->truncate();
      factory(User::class)->create([
        'email' => 'existing-email@correo.com',
      ]);
      $user = factory(User::class)->create([
        'email' => 'moises@correo.com',
      ]);

      $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
          'name' => 'Mara',
          'email' => 'existing-email@correo.com',
          'password' => '123456'
        ])
        ->assertRedirect("usuarios/{$user->id}/editar")
        ->assertSessionHasErrors(['email']); //(users.show)

    }


    /** @test */
    public function the_users_email_can_stay_the_same_when_updating_the_user()
    {
      //self::markTestIncomplete();
      //return;
      $user = factory(User::class)->create([
        'email' => 'mara@correo.com',
      ]);

      $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
          'name' => 'Mara',
          'email' => 'mara@correo.com',
          'password' => '123456'
        ])
        ->assertRedirect("usuarios/{$user->id}"); //(users.show)

      $this->assertDatabaseHas('users', [
        'name' => 'Mara',
        'email' => 'mara@correo.com',
      ]);
    }

    /** @test */
  /*  public function it_password_is_required_when_updating_the_user()
    {
      //$this->withoutExceptionHandling();
      $user = factory(User::class)->create();
      $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
          'name' => 'Mara',
          'email' => 'mara@correlati.com',
          'password' => '',
        ])
        ->assertRedirect("usuarios/{$user->id}/editar")
        ->assertSessionHasErrors(['password']);

      $this->assertDatabaseMissing('users', ['email' => 'mara@correlati.com']);
    }*/
    /** @test */
    public function it_password_is_optional_when_updating_the_user()
    {
     //$this->withoutExceptionHandling();
     $oldPassword = 'CLAVE_ANTERIOR';
     $user = factory(User::class)->create([
       'password' => bcrypt($oldPassword)
     ]);
     $this->from("usuarios/{$user->id}/editar")
       ->put("usuarios/{$user->id}", [
         'name' => 'Mara',
         'email' => 'mara@correlati.com',
         'password' => '',
       ])
       ->assertRedirect("usuarios/{$user->id}"); //)sers.show)

       $this->assertCredentials([
         'name' => 'Mara',
         'email' => 'mara@correlati.com',
         'password' => $oldPassword
       ]);
    }

    /** @test */
    public function it_deletes_a_user()
    {
     //$this->withoutExceptionHandling();
     $user = factory(User::class)->create([
       'email' => 'mara1@correo.com',
     ]);

     $this->delete("usuarios/{$user->id}")
       ->assertRedirect("usuarios"); //)sers.show)

      $this->assertDatabaseMissing('users',[
        'id' => $user->id
      ]);

      //$this->assertSame(0, User::count());

    }

}
