<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'resolved', 'reopened', 'closed'])->default('pending');

            $table->unsignedBigInteger('assigned_to')->index()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('assigned_by')->index()->nullable();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
