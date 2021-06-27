<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('description');
            $table->string('fix_or_movable');
            $table->string('picture_path');
            $table->string('purchase_date');
            $table->string('start_use_date');
            $table->decimal('purchase_price', 9, 2);
            $table->string('warranty_expire_date');
            $table->integer('degradation_in_years');
            $table->decimal('current_value_in_naira', 9, 2);
            $table->string('location');
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
        Schema::dropIfExists('assets');
    }
}
