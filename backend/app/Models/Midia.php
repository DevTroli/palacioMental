<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia extends Model
{
    use HasFactory;

    protected $fillable = ['projeto_id', 'tipo', 'url'];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
        ];
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
