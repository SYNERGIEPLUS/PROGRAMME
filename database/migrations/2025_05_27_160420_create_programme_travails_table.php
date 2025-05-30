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
        Schema::create('programme_travails', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('ctx');
            $table->string('verif');
            $table->json('generale'); // On stocke la liste comme JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programme_travails');
    }
};
