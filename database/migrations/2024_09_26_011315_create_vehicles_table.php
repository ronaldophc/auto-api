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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('type'); // Automóveis, SUVs, Motos.
            $table->string('model'); // Gol, Palio, CB300, Peugeot
            $table->string('manufacturer'); // Hyundai, Ford, Honda, Yamaha
            $table->string('fuel_type')->nullable(); // Gasolina, Álcool, Flex, Diesel
            $table->string('color')->nullable(); // Branco, Preto, Prata, Vermelho
            $table->string('steering_type')->nullable(); // Mecânica, Hidráulica, Elétrica
            $table->string('transmission')->nullable(); // Automática, Manual
            $table->integer('doors')->nullable(); // Número de portas (aplicável apenas para automóveis)
            $table->year('manufacture_year')->nullable(); // Ano de fabricação
            $table->year('model_year')->nullable(); // Ano do modelo
            $table->integer('current_km')->nullable(); // Quilometragem atual
            $table->decimal('price', 10, 2); // Preço
            $table->boolean('is_new')->nullable()->default(false); // Novidade
            $table->boolean('is_featured')->nullable()->default(false); // Destaque
            $table->string('license_plate')->nullable()->unique(); // Não exibido publicamente - Placa do veículo
            $table->string('renavam')->nullable(); // Não exibido publicamente
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
