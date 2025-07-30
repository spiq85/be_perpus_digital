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
        Schema::create('books', function (Blueprint $table) {
            $table->id('id_book');
            $table->string('title');
            $table->string("slug");
            $table->text('description');
            $table->integer('rating_counts')->default(0);
            $table->year('publication_year');
            $table->timestamps();

            $table->foreignId('id_category')->constrained('categories', 'id_category')->onDelete('cascade');
            $table->foreignId('id_author')->constrained('authors', 'id_author')->onDeleete('cascade');
            $table->foreignId("id_publisher")->constrained('publishers', 'id_publisher')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
