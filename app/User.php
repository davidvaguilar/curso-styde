<?php

namespace App;

use Illuminate\Support\Facades\DB;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    /*public static function createUser($data){
      DB::transaction(function() use ( $data) {
        $user = User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
        ]);

        $user->profile()->create([
          'bio' => $data['bio'],
          'twitter' => $data['twitter'],
        ]);
      });
    }*/

    public static function findByEmail($email){
      return static::where(compact('email'))->first();
    }

    public function profession(){  //profession_id
      return $this->belongsTo(Profession::class, 'profession_id');
    }

    public function profile(){
      return $this->hasOne(UserProfile::class);
    }

    public function isAdmin(){
      //return $this->email === 'david@david.cl';
      return $this->is_admin;
    }
}
