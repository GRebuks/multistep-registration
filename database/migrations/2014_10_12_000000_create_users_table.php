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
        /* NOTICE:
         * In order to have a 3NF (Third Normal Form) database, we would need to create a new table for the country code and phone number.
         * However, for the sake of simplicity, we will keep the country code and phone number in the users table.
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //
            $table->string('surname'); //
            $table->string('email')->unique(); //
            $table->string('username')->unique(); //
            $table->date('birthday');
            $table->string('country_code');
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(
            array(
                'name' => 'John',
                'surname' => 'Doe',
                'email' => '',
                'username' => 'johndoe',
                'birthday' => '1990-01-01',
                'country_code' => '1',
                'phone' => '1234567890',
                'password' => 'password',
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
