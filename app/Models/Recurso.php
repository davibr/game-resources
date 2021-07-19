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

    public function scopeOrderByJogo($query) {
        $query->join('jogos', 'recursos.jogo_id', '=', 'jogos.id')->orderBy('jogos.nome');
    }

    public function scopeOrderByNome($query) {
        $query->orderBy('nome');
    }

    public function scopeFiltro($query, array $filtros)
    {
        $query->when($filtros['pesquisa'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nome', 'like', '%'.$search.'%');
            });
        });
    }
}