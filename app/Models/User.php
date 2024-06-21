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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function getRegras()
    {
        $regras = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        return $regras;
    }

    public static function getMensagens()
    {
        $menssagens = [
            'email.required' => 'O campo email é obrigatório!',
            'password.required' => 'O campo senha é obrigatório!',
            'password.min' => 'O campo senha precisa ter no mínimo 5 caracteres!',
        ];

        return $menssagens;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
