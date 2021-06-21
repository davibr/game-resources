<?php

namespace Database\Seeders;

use App\Models\TipoRecurso;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TiposRecursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = TipoRecurso::firstOrCreate(['nome' => 'Guia TXT'], ['nome' => 'Guia TXT']);
        $user = TipoRecurso::firstOrCreate(['nome' => 'Guia HTML'], ['nome' => 'Guia HTML']);
        $user = TipoRecurso::firstOrCreate(['nome' => 'Mapa/Gráfico'], ['nome' => 'Mapa/Gráfico']);
    }
}
