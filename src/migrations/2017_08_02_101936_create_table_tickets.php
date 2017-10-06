<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('subject');
                $table->enum('status', ['open', 'close', 'wait'])->default('open');

                $table->timestamps();
                $table->softDeletes();
            });
        }else if (!Schema::hasTable('tickets_data')) {
            Schema::create('tickets_data', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('tickets_id');
                $table->tinyInteger('is_admin');
                $table->text('message');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::dropIfExists('tickets');
        Schema::dropIfExists('tickets_data');
    }
}
