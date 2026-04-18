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
        // Ubah format ID lama (customer-x) jadi hanya angkanya (x) supaya muat di varchar(10)
        // dan bisa lanjut lebih dari 9 tanpa error "Data too long".
        DB::statement("
            UPDATE customers
            SET id_customer = SUBSTRING_INDEX(id_customer, '-', -1)
            WHERE id_customer LIKE 'customer-%'
        ");

        // Siapkan index unik untuk id_customer supaya foreign key dari orders tetap valid
        // setelah primary key di-drop dari id_customer.
        $indexExists = DB::select("SHOW INDEX FROM customers WHERE Key_name = 'customers_id_customer_unique'");
        if (empty($indexExists)) {
            Schema::table('customers', function (Blueprint $table) {
                $table->unique('id_customer', 'customers_id_customer_unique');
            });
        }

        // Drop primary key lama (id_customer) jika masih ada
        $primary = DB::select("SHOW INDEX FROM customers WHERE Key_name = 'PRIMARY'");
        $primaryColumns = array_map(fn ($row) => $row->Column_name ?? null, $primary);
        if (in_array('id_customer', $primaryColumns, true)) {
            Schema::disableForeignKeyConstraints();
            DB::statement('ALTER TABLE customers DROP PRIMARY KEY');
            Schema::enableForeignKeyConstraints();
        }

        // Tambah primary key baru bertipe integer (auto increment) jika belum ada
        if (! Schema::hasColumn('customers', 'id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->bigIncrements('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan primary key ke id_customer (string) jika rollback.
        // Catatan: rollback ini tidak mengembalikan format "customer-x" pada data.
        DB::statement('ALTER TABLE customers DROP PRIMARY KEY');

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        DB::statement('ALTER TABLE customers ADD PRIMARY KEY (id_customer)');
    }
};
