<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'projeto_id', 'conteudo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
