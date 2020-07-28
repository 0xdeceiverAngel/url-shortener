<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_mapping', function (Blueprint $table) {
            $table->text('redirect_url')->default(NULL)->nullable($value = true);
            $table->text('file_name')->default(NULL)->nullable($value = true);
            $table->text('extension')->default(NULL)->nullable($value = true);
            $table->text('password')->default(NULL)->nullable($value = true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_mapping');
    }
}
