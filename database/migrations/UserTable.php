<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * User table migration.
 */
class UserTable
{
    /**
     * Create user table.
     */
    public function create()
    {
        // Create user table
        Capsule::schema()->create('users', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Drop user table.
     */
    public function drop()
    {
        Capsule::schema()->dropIfExists('users');
    }
}