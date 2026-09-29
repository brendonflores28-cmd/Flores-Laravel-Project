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
        DB::statement("
            ALTER TABLE categories
            MODIFY name VARCHAR(255) NOT NULL AFTER id,
            MODIFY description TEXT NOT NULL AFTER name,
            MODIFY status VARCHAR(255) NOT NULL DEFAULT 'active' AFTER description,
            MODIFY created_at TIMESTAMP NULL AFTER status,
            MODIFY updated_at TIMESTAMP NULL AFTER created_at,
            MODIFY deleted_at TIMESTAMP NULL AFTER updated_at
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
