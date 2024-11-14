<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('quantity');
            $table->string('image');
            $table->string('images');
            $table->decimal('price', 18, 2);
            $table->decimal('order_number', 18, 0);
            $table->unsignedBigInteger('label_id')->nullable();
            $table->timestamps();
            // Foreign keys
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('products');
    }
};
