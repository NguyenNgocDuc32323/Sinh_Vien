<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('order_details', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');
        $table->unsignedBigInteger('product_id');
        $table->integer('quantity');
        $table->decimal('price', 18, 2);
        $table->string('product_name', 255);
        $table->string('product_image', 255)->nullable();
        $table->string('color', 50)->nullable();
        $table->string('size', 50)->nullable();
        $table->timestamps();
        $table->foreign('order_id')
              ->references('id')
              ->on('orders')
              ->onDelete('cascade');

        $table->foreign('product_id')
              ->references('id')
              ->on('products')
              ->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
