<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mix_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('female_id')
                ->constrained('female_pigs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('male_first_id')
                ->constrained('male_pigs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('male_second_id')
                ->nullable()
                ->constrained('male_pigs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('mix_day');
            $table->date('recurrence_first_schedule');
            $table->date('recurrence_second_schedule');
            $table->date('delivery_schedule');
            $table->date('trouble_day')->nullable();
            $table->foreignId('trouble_id')
                ->default(1)
                ->constrained('trouble_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('born_day')->nullable();
            $table->integer('born_num')->nullable();
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
        Schema::dropIfExists('mix_infos');
    }
}
