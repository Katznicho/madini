<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade')
            $table->foreignId("cooperative_id")->references("id")->on("cooperatives")->onDelete("cascade");
            $table->foreignId("delivery_address_id")->references("id")->on("delivery_addresses")->onDelete("cascade");
            $table->string("total_cost");
            $table->string("purchase_cost");
            $table->string("delivery_cost");
            $table->string('quantity');
            $table->string('status')->default("Pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
