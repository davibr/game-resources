<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    public function jogo() {
        return $this->belongsTo(Jogo::class);
    }

    public function tipo_recurso() {
        return $this->belongsTo(TipoRecurso::class);
    }

    public function scopeOrderByNome($query) {
        $query->orderBy('nome');
    }
}