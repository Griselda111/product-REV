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
        Schema::table('orders', function (Blueprint $table) {

            // FILE
            $table->string('bukti_transfer')->nullable();
            $table->string('file_desain_customer')->nullable();
            $table->string('file_mockup')->nullable();

            // PEMBAYARAN
            $table->tinyInteger('jenis_pembayaran')->default(1);// 1=Cash, 2=Transfer

            // DESAIN
            $table->tinyInteger('kondisi_desain')->default(1);// 1=Belum ada desain, 2=Sudah ada desain
            $table->tinyInteger('status_desain')->default(1);// 1=Belum direvisi, 2=Revisi, 3=Final

            $table->string('catatan_revisi')->nullable();


        }); //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'bukti_transfer',
                'file_desain_customer',
                'file_mockup',
                'jenis_pembayaran',
                'kondisi_desain',
                'status_desain',
                'catatan_revisi'
            ]);
        });
    }
};