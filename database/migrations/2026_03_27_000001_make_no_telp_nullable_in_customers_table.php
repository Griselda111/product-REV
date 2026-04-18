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
        // Hindari penggunaan ->change() karena butuh doctrine/dbal.
        DB::statement('ALTER TABLE customers MODIFY no_telp VARCHAR(20) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('customers')->whereNull('no_telp')->update(['no_telp' => '']);

        // Hindari penggunaan ->change() karena butuh doctrine/dbal.
        DB::statement('ALTER TABLE customers MODIFY no_telp VARCHAR(20) NOT NULL');
    }
};
