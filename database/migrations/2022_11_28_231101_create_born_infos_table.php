<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBornInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('born_infos', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('mix_id')
                ->unique()
                ->constrained('mix_infos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('born_day');
            $table->integer('born_num');
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
        Schema::dropIfExists('born_infos');
    }
}
