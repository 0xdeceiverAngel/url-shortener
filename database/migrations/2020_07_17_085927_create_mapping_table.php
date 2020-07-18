<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapping', function (Blueprint $table) {
            $table->text('org_url')->default(NULL)->nullable($value = true);
            $table->text('redirect_url')->default(NULL)->nullable($value = true);
            $table->unsignedInteger('redirect_times')->default('0')->nullable($value = true);
            $table->dateTimeTz('creat_time')->default(NULL)->nullable($value = true);
            $table->dateTimeTz('last_time_use')->default(NULL)->nullable($value = true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapping');
    }
}
