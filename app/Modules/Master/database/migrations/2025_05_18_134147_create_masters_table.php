<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('experience')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Таблица связи мастеров и специализаций
        Schema::create('master_specialization', function (Blueprint $table) {
            $table->foreignId('master_id')->constrained()->onDelete('cascade');
            $table->foreignId('specialization_id')->constrained()->onDelete('cascade');
            $table->primary(['master_id', 'specialization_id']);
        });

        // Таблица связи мастеров и услуг
        Schema::create('master_service', function (Blueprint $table) {
            $table->foreignId('master_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->primary(['master_id', 'service_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_service');
        Schema::dropIfExists('master_specialization');
        Schema::dropIfExists('masters');
    }
};
