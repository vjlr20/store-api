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
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // ID automatico
            $table->string('names', 80); // Nombre del cliente (string -> varchar)
            $table->string('lastnames', 120);
            $table->date('born_date');
            $table->string('dui', 10)->unique();
            $table->text('address');
            $table->timestamps(); // Fechas automaticas
            // deleted_at
            $table->softDeletes(); // Activando borrado suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
