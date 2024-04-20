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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('senderId')->unsigned();
            $table->bigInteger('receiverId')->unsigned();
            $table->text('messageBody');
            $table->timestamps();

            $table->foreign('senderId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receiverId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
