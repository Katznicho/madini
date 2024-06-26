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
        Schema::create('cooperatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("description")->nullable();
            $table->string("logo")->nullable();
            $table->string("status")->default("active");
            $table->string("phone_number")->nullable();
            $table->string("email")->nullable();
            $table->string("website")->nullable();
            $table->string("account_number")->nullable();
            $table->string("address")->nullable();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperatives');
    }
};
