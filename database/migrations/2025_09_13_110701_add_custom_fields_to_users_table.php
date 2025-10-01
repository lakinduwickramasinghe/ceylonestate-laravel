<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->string('username')->unique()->after('id');
            $table->string('first_name')->after('username');
            $table->string('last_name')->after('first_name');

            $table->enum('role', ['admin','member'])->default('member')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn(['username', 'first_name', 'last_name', 'role','name']);
        });
    }
};
