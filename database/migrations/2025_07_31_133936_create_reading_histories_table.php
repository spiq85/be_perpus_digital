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
            Schema::create('reading_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
                $table->foreignId('id_book')->constrained('books', 'id_book')->onDelete('cascade');
                $table->timestamp('read_at');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('reading_histories');
        }
    };
