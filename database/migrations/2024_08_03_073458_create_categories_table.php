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
        // Create the table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('in_active')->default(true);
            $table->timestamps();
        });

        // Rename column
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('in_active', 'is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename column back to original
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('is_active', 'in_active');
        });

        // Drop the table
        Schema::dropIfExists('categories');
    }
};

