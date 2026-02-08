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
        Schema::table('loans', function (Blueprint $table) {
            // Kita definisikan ulang enum-nya dengan menambah 'pending'
            $table->enum('status', ['borrowed', 'returned', 'overdue', 'pending'])
                ->default('borrowed')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Kembalikan ke opsi semula jika migrasi di-rollback
            $table->enum('status', ['borrowed', 'returned', 'overdue'])
                ->default('borrowed')
                ->change();
        });
    }
};
