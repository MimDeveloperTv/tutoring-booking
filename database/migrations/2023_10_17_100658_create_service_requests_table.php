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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('consumer_id');
            $table->foreign('consumer_id')->references('id')->on('consumers')->onDelete('cascade');
            $table->uuid('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
            $table->unsignedBigInteger('service_model_item_id');
            $table->foreign('service_model_item_id')->references('id')->on('service_model_items')->onDelete('cascade');
            $table->enum('visibility',['PUBLIC','PRIVATE'])->default('PRIVATE');
            $table->enum('status',['PENDING','ACCEPT','CANCELED'])->default('PENDING');
            $table->uuid('accepted_by')->nullable();
            $table->foreign('accepted_by')->references('id')->on('operators')->onDelete('cascade');
            $table->timestamp('accepted_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
