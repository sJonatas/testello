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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients', 'id');
            $table->string('from_postcode', 10);
            $table->string('to_postcode', 10);
            $table->string('from_weight', 10);
            $table->string('to_weight', 10);
            $table->float('cost');
            $table->integer('branch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
