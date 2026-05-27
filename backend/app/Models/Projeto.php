<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'descricao',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function midias()
    {
        return $this->hasMany(Midia::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'projeto_tag')->withTimestamps();
    }

    public function curtidas()
    {
        return $this->belongsToMany(User::class, 'curtidas')->withTimestamps();
    }

    public function salvos()
    {
        return $this->belongsToMany(User::class, 'salvos')->withTimestamps();
    }

    public function scopePublico($query)
    {
        return $query->where('status', 'publico');
    }
}
