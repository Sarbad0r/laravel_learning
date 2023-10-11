<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //HasApiTokens -> is for creating tokens 

    //hasfactory -> is for creating random data in table using factories

    //Notifiable -> is for sending message or email message to user

    protected $table = 'users';

    protected $guarded = ['id'];

    public function chats()
    {
        return $this->hasMany(ChatModel::class, 'created_by');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    // "self" uses in static methods of class
    // to get static fields or some static things of class
    static public function get_users_with_updated_at_in_static_method()
    {
        return self::whereNotNull('updated_at');
    }

    // "$this" is the same class, usually it uses in simple not static methods
    // we can use here "self" too, but it's not properly.
    public function get_users_with_updated_at_in_simple_func()
    {
        return $this->whereNotNull('updated_at');
    }
}
