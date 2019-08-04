<?php

use App\User;
use App\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$professions = DB::select('SELECT id FROM professions WHERE title = ? LIMIT 0,1', ['Desarrollador back-end']);
        //$professions = DB::table('professions')->select('id')->take(1)->get();
        //$profession = DB::table('professions')->where('title', '=', 'Desarrollador back-end')->first();
    /*    $profession = DB::table('professions')
          ->where(['title' => 'Desarrollador back-end'])
          ->first();*/
      /*  $professionId = DB::table('professions')
          ->where(['title' => 'Desarrollador back-end'])
          ->value('id');*/
      //  $professionId = DB::table('professions')->whereTitle('Desarrollador back-end')->value('id');
      //  $professionId = Profession::whereTitle('Desarrollador back-end')->value('id');
        $professionId = Profession::where('title','Desarrollador back-end')->value('id');
      //  $profession = DB::table('professions')->select('id', 'title')->where('title', '=', 'Desarrollador back-end')->first();
        //$profession = DB::table('professions')->select('id')->first();
        //dd($professions->first()->id);

        //dd($professionId);
        //dd($professions[0]->id);

        //DB::table('users')->insert([
        User::create([
          'name' => 'David Villegas',
          'email' => 'david@david.cl',
          'password' => bcrypt('laravel'),
          'profession_id' => $professionId,
          'is_admin' => true,
        ]);

        factory(User::class)->create([
          'password' => bcrypt('laravel'),
          'profession_id' => $professionId,
          'is_admin' => true,
        ]);

        factory(User::class)->create([
          'profession_id' => $professionId,
        ]);

        factory(User::class)->create();

        User::create([
          'name' => 'Joel',
          'email' => 'joel@correo.cl',
          'password' => bcrypt('laravel'),
          'profession_id' => $professionId,
        ]);

        User::create([
          'name' => 'Ellie',
          'email' => 'ellie@correo.cl',
          'password' => bcrypt('laravel'),
          'profession_id' => null,
        ]);

        factory(User::class, 48)->create();
    }
}
