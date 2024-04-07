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
        Schema::create('service_model_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_model_id');
            $table->foreign('service_model_id')->references('id')->on('service_models')->onDelete('cascade');
            $table->string('label');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_model_items');
    }
};
