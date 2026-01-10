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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // 1. ID interno de Laravel

            // 2. Relaciones
            // Categoría obligatoria (Todo producto debe tener categoría)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Usuario es NULLABLE (La clave de tu proyecto)
            // - Si es NULL: Es un producto público de la API (lo ve todo el mundo)
            // - Si tiene ID: Es un producto privado de ese usuario
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // 3. ID externo de la API
            // Nullable porque los productos que cree Edu a mano no tendrán ID de Bedca
            $table->integer('bedca_id')->nullable();

            // 4. Datos del producto
            $table->string('name');

            // 5. Macronutrientes
            // Usamos 'decimal' (8 dígitos en total, 2 decimales) para precisión.
            // Ponemos default(0) para que si la API no trae el dato, se guarde como 0 y no dé error.
            $table->decimal('calories', 8, 2)->default(0);      // Calorías (Kcal)
            $table->decimal('fats', 8, 2)->default(0);          // Grasa Total
            $table->decimal('proteins', 8, 2)->default(0);      // Proteínas
            $table->decimal('carbohydrates', 8, 2)->default(0); // Carbohidratos
            $table->decimal('fiber', 8, 2)->default(0);         // Fibra
            $table->decimal('cholesterol', 8, 2)->default(0);   // Colesterol
            
            // Tipos de grasas detalladas
            $table->decimal('fats_sat', 8, 2)->default(0);      // Saturadas
            $table->decimal('fats_mono', 8, 2)->default(0);     // Monoinsaturadas
            $table->decimal('fats_poly', 8, 2)->default(0);     // Poliinsaturadas

            $table->timestamps(); // Created_at y Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
