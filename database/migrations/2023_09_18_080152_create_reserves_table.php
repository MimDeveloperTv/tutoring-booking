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
        Schema::create('reserves', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('consumer_id');
            $table->foreign('consumer_id')->references('id')->on('consumers')->onDelete('cascade');
            $table->uuid('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
            $table->unsignedBigInteger('service_application_place_id');
            $table->foreign('service_application_place_id')->references('id')->on('service_application_places')->onDelete('cascade');
            $table->unsignedBigInteger('service_model_item_id');
            $table->foreign('service_model_item_id')->references('id')->on('service_model_items')->onDelete('cascade');
            $table->enum('payment_status',['PENDING','SUCCESS','FAILED'])->default('PENDING');
            $table->enum('status',['NEW','CANCELED','COMPLETED','REVIEWED'])->default('NEW');
            $table->decimal('amount',14,2,false);
            $table->string('currency');
            $table->integer('from');
            $table->integer('to');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
