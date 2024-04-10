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
        Schema::create('miners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("phone_number");
            $table->string("email")->nullable();
            $table->string("profile_picture")->nullable();
            $table->string("gender")->nullable();
            $table->string("address")->nullable();
            $table->string("account_number");
            $table->string("status")->default("active");
            $table->foreignId("cooperative_id")->references("id")->on("cooperatives")->onDelete("cascade");
            $table->string("pin")->nullable();
            $table->string("pin_recovery")->nullable();
            $table->string("pin_reset")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miners');
    }
};
