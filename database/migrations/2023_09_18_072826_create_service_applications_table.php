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
        Schema::create('service_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            // $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->uuid('operator_id');
            // $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('break')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('online')->default(0);
            $table->boolean('onAnotherSite')->default(0);
            $table->boolean('isActive')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_applications');
    }
};
