<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Password reset migration.
 */
class PasswordResetTable
{
    /**
     * Create password reset table.
     */
    public function create()
    {
        // Create password reset table
        Capsule::schema()->create('password_resets', function($table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    /**
     * Drop password reset table.
     */
    public function drop()
    {
        Capsule::schema()->dropIfExists('password_resets');
    }
}