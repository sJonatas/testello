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
        Schema::create('imported_files', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 150);
            $table->integer('size');
            $table->enum('status', \App\Enum\Statuses::values())->default(\App\Enum\Statuses::NaFila->value);
            $table->text('failure')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imported_files');
    }
};
