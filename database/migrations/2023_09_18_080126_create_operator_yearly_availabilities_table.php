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
        Schema::create('operator_yearly_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_application_id');
            $table->foreign('service_application_id')->references('id')->on('service_applications')->onDelete('cascade');
            $table->unsignedBigInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('service_application_places')->onDelete('cascade');
            $table->timestamp('date');
            $table->boolean('online')->default(0);
            $table->boolean('onAnotherSite')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_yearly_availabilities');
    }
};
