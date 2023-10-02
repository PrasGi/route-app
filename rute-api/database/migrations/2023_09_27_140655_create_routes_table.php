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
        Schema::create('routes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->integer('long_route')->nullable();
            $table->integer('height_start')->nullable();
            $table->integer('height_end')->nullable();
            $table->enum('level', ['easy', 'medium', 'hard']);
            $table->char('village_id');
            $table->foreign('village_id')->references('id')->on('villages');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('uuid')->on('users');
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
