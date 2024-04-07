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
        Schema::create('service_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_category_id');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('condition')->nullable(); //planning_refractive_prk
            $table->string('calculation')->nullable(); //planning_refractive_prk
            $table->boolean('isActive')->default(1);
            $table->string('items')->nullable();
            $table->enum('created_by', ['SYSTEM', 'USER'])->default('USER');
            $table->boolean('are_items_independent')->default(0);
            $table->boolean('non_prescription')->default(0);
            $table->unsignedBigInteger('form_id')->nullable();
//            $table->enum('type',['SOFT','HARD'])->default('SOFT');
//            $table->string('type_name')->unique();
//            $table->json('default_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_models');
    }
};
