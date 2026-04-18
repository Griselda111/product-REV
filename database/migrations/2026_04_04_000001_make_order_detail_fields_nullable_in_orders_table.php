<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop FK before altering column definitions
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['jasa_id']);
        });

        // NOTE: gunakan raw SQL agar tidak perlu doctrine/dbal untuk ->change()
        DB::statement('ALTER TABLE `orders` MODIFY `jasa_id` BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE `orders` MODIFY `tarif` DECIMAL(15,2) NULL');
        DB::statement('ALTER TABLE `orders` MODIFY `jumlah` INT NULL');
        DB::statement('ALTER TABLE `orders` MODIFY `total_tagihan` DECIMAL(15,2) NULL');

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('jasa_id')
                ->references('id')
                ->on('jasas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['jasa_id']);
        });

        DB::statement('ALTER TABLE `orders` MODIFY `jasa_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `orders` MODIFY `tarif` DECIMAL(15,2) NOT NULL');
        DB::statement('ALTER TABLE `orders` MODIFY `jumlah` INT NOT NULL');
        DB::statement('ALTER TABLE `orders` MODIFY `total_tagihan` DECIMAL(15,2) NOT NULL');

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('jasa_id')
                ->references('id')
                ->on('jasas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }
};
