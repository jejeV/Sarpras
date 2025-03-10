b<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praktiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id');
            $table->foreignId('kompeten_id');
            $table->string('jml_ruang');
            $table->enum('status', ['ideal', 'tidak_ideal']);
            $table->string('jml_ideal');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('praktiks');
    }
};
