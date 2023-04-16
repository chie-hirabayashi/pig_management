<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWellFlagToFemalePigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('female_pigs', function (Blueprint $table) {
            $table->boolean('well_flag')->default(0)->after('recurrence_flag');
            $table->boolean('unwell_flag')->default(0)->after('well_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('female_pigs', function (Blueprint $table) {
            //
        });
    }
}
