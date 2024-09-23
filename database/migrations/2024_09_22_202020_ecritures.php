<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecritures', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('journal_id')->constrained('journaux')->onDelete('cascade');
            //$table->foreignId('compte_id')->constrained('comptes')->onDelete('cascade');
            $table->foreignId('plan_comptable_id')->constrained('plan_comptable')->onDelete('cascade'); 
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->date('date');
            $table->unsignedBigInteger('ecriture_associee_id')->nullable();
            //$table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade'); // Assure-toi que cette ligne est correcte

            $table->string('reference')->nullable(); // Rend la colonne nullable
            $table->string('libelle');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecritures');
    }
};
