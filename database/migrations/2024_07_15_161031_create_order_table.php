<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('code', 100)->unique();
        $table->unsignedBigInteger('user_id');
        $table->string('shipping_method', 255)->nullable();
        $table->string('status', 255)->nullable();
        $table->decimal('amount', 18, 2);
        $table->decimal('discount_amount', 18, 2);
        $table->decimal('shipping_amount', 18, 2);
        $table->string('description')->nullable();
        $table->decimal('sub_total', 18, 2);
        $table->boolean('is_finished')->default(false);
        $table->timestamp('completed_at')->nullable();
        $table->unsignedBigInteger('payment_id')->nullable();
        $table->string('address');
        $table->timestamps();
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
        $table->foreign('payment_id')
              ->references('id')
              ->on('payments')
              ->onDelete('set null');
    });
}
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
