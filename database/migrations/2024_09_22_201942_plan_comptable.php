<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_comptable', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numero_compte')->unique();
            $table->string('nom_compte');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_comptable');
    }
};
