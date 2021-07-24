<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCampoMarcarPosicaoFromRecursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recursos', function (Blueprint $table) {
            $table->removeColumn('marcar_posicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recursos', function (Blueprint $table) {
            $table->boolean('marcar_posicao')->default(false);
        });
    }
}
