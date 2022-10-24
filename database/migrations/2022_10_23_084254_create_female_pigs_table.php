<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFemalePigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('female_pigs', function (Blueprint $table) {
            $table->id();
            $table->char('individual_num', 20);
            $table->date('add_day');
            $table->date('left_day')->nullable();
            $table->boolean('warn_flag')->default(0);
            $table->timestamps();

            // 論理削除
            $table->softDeletes();

            // 論理削除でnull,存在で1になるexistカラムを定義
            $table->boolean('exist')->nullable()->storedAs('case when deleted_at is null then 1 else null end');

            // 複合ユニーク成約
            $table->unique(['individual_num', 'exist']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('female_pigs');
    }
}
