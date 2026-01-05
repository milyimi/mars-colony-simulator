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
        Schema::create('colonies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->default('第1コロニー');
            $table->integer('oxygen')->default(100);
            $table->integer('water')->default(100);
            $table->integer('power')->default(100);
            $table->integer('food')->default(100);
            $table->integer('population')->default(5);
            $table->integer('oxygen_facility')->default(1);
            $table->integer('water_facility')->default(1);
            $table->integer('power_facility')->default(1);
            $table->integer('food_facility')->default(1);
            $table->integer('turn')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colonies');
    }
};
