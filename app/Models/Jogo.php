<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jogo extends Model
{
    public function recursos() {
        return $this->hasMany(Recurso::class);
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