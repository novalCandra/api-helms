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
        Schema::create('helments', function (Blueprint $table) {
            $table->id();
            $table->string('helmend_code');
            $table->enum('type', ['Standard', 'Premium', 'Industrial'])->default('Standard');
            $table->enum('condition', ['Excallent', 'Good', 'Fair'])->default('Good');
            $table->enum('status', ['Avaible', 'Borrowed', 'Maintenance', 'Retired'])->default('Avaible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helments');
    }
};
