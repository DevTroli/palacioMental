<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'username', 'bio', 'avatar_url'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function curtidas()
    {
        return $this->belongsToMany(Projeto::class, 'curtidas')->withTimestamps();
    }

    public function salvos()
    {
        return $this->belongsToMany(Projeto::class, 'salvos')->withTimestamps();
    }
}
