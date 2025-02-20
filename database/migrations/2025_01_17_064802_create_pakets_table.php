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
            Schema::create('tb_paket', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_outlet');
                $table->enum('jenis', ['kiloan', 'selimut', 'bed_cover', 'kaos', 'lain']);
                $table->string('nama_paket', 100);
                $table->integer('harga');
                $table->timestamps();

                $table->foreign('id_outlet')->references('id')->on('tb_outlet')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pakets');
        }
    };
