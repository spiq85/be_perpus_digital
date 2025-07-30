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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('id_rating');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete("cascade");
            $table->foreignId('id_book')->constrained('books', 'id_book')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->timestamps();

            // Satu user hanya dapat memberikan sekali rating per buku
            $table->unique(['id_user' , 'id_book']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
