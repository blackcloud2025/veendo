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
        'role'
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //borrar productos del usuario borrado
    public function products()
    {
        return $this->hasMany(Product::class)->onDelete('cascade');
    }

    //mostar productos del usuario en el dashboard 
    public function userProducts()
    {
        return $this->hasMany(Product::class);
    }



    // checa  si es administrador
    public function isAdmin()
    {
        return $this->role === 'admin'; 
    }

    //checa si es publicador
    public function isPublisher()
    {
        return $this->role === 'publisher';
    }
}
