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
        Schema::create('favorites', function (Blueprint $table) {
            $table->foreignId('id_user')->constrained('users' , 'id_user')->onDelete('cascade');
            $table->foreignId('id_book')->constrained('books' , 'id_book')->onDelete('cascade');
            $table->primary(['id_user' , 'id_book']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
