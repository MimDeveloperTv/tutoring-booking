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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_model_id');
            $table->foreign('service_model_id')->references('id')->on('service_models')->onDelete('cascade');
            $table->uuid('user_collection_id');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->integer('default_price');
            $table->integer('default_duration');
            $table->integer('default_break');
            $table->integer('default_capacity');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
