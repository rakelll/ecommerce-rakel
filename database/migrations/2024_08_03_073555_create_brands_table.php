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

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('in_active')->default(true);
            $table->timestamps();
        });
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'in_active')) {
                $table->renameColumn('in_active', 'is_active');
            }
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'is_active')) {
                $table->renameColumn('is_active', 'in_active');
            }
        });
    }
};
