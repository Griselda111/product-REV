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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order')->unique();
            $table->string('id_customer');
            $table->string('nama_pemesan');
            $table->date('tanggal_pesan');
            $table->date('tanggal_target_selesai')->nullable();
            $table->foreignId('jasa_id')->constrained('jasas')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('tarif', 15, 2);
            $table->integer('ukuran');
            $table->integer('jumlah');
            $table->decimal('total_tagihan', 15, 2);
            $table->tinyInteger('status_pembayaran')->default(1); // 1=belum lunas, 2=lunas, 3=dp
            $table->date('tanggal_mulai_proses')->nullable();
            $table->date('tanggal_selesai_proses')->nullable();
            $table->tinyInteger('status_produksi')->default(1); // 1=belum diproses, 2=sedang diproses, 3=selesai
            $table->date('tanggal_diambil')->nullable();
            $table->string('catatan', 2000)->nullable();
            $table->timestamps();

            $table->foreign('id_customer')
                ->references('id_customer')
                ->on('customers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
