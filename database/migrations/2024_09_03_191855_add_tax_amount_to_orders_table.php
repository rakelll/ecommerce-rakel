<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddTaxAmountToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('tax_amount', 10, 2)->nullable()->after('grand_total');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
      {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('tax_amount');
        });
    }
};
