<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_checks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('judul');
            $table->text('abstraksi');
            $table->float('persentase_judul');
            $table->float('persentase_abstraksi');
            $table->integer('status');
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
        Schema::dropIfExists('history_checks');
    }
}
