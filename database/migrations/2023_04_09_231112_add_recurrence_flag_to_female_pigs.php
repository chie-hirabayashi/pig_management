<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecurrenceFlagToFemalePigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('female_pigs', function (Blueprint $table) {
            $table->boolean('recurrence_flag')->default(0)->after('warn_flag');
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
