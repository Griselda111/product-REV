<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // NOTE: gunakan raw SQL agar tidak perlu doctrine/dbal untuk ->change()
        DB::statement('ALTER TABLE `orders` MODIFY `catatan_revisi` VARCHAR(2000) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `orders` MODIFY `catatan_revisi` VARCHAR(255) NULL');
    }
};
