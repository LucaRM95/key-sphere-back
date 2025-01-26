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
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->string('title');
            $table->string('address');
            $table->text('description');
            $table->float('lat');
            $table->float('lng');
            $table->json('images');
            $table->string('type');
            $table->string('status');
            $table->boolean('is_active')->default(true);
            $table->float('price');
            $table->float('area');
            $table->integer('beds');
            $table->integer('baths');
            $table->timestamps();

            $table->uuid('user_id');  // Foreign key as UUID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
