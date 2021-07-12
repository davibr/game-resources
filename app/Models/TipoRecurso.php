<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class TipoRecurso extends Model
{
    protected $table = 'tipos_recursos';

    public function scopeOrderById($query) {
        $query->orderBy('id');
    }
}