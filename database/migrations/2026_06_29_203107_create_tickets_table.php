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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Tko je prijavio kvar
            $table->foreignId('category_id')->constrained(); // Iz koje kategorije je kvar
            $table->string('title'); // Kratki naslov kvara (npr. "Ne radi printer u računovodstvu")
            $table->text('description'); // Detaljan opis kvara
            $table->string('priority')->default('low'); // low, medium, high, critical
            $table->string('status')->default('novo'); // novo, u_obradi, rijeseno
            $table->text('admin_notes')->nullable(); // Tvoje interne bilješke o popravku
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
