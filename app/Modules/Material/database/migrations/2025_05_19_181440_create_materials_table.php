<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('unit')->default('шт.');
            $table->decimal('price', 8, 2)->default(0);
            $table->integer('min_threshold')->nullable();
            $table->timestamps();
        });

        // Таблица связи материалов и услуг
        Schema::create('material_service', function (Blueprint $table) {
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_used')->default(1);
            $table->primary(['material_id', 'service_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_service');
        Schema::dropIfExists('materials');
    }
};
