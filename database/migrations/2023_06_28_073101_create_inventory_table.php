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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->bigInteger('price');
            $table->integer('quantity');
            $table->string('category');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
        // Add 20 items to the inventory table
        DB::table('inventory')->insert(
            array(
                'name' => 'Apple',
                'description' => 'A red apple',
                'price' => 199,
                'quantity' => 1000,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Banana',
                'description' => 'A yellow banana',
                'price' => 154,
                'quantity' => 1200,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Orange',
                'description' => 'A orange orange',
                'price' => 9,
                'quantity' => 100,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Pear',
                'description' => 'A green pear',
                'price' => 499,
                'quantity' => 10,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Grape',
                'description' => 'A purple grape',
                'price' => 699,
                'quantity' => 114200,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Strawberry',
                'description' => 'A red strawberry',
                'price' => 299,
                'quantity' => 10023,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Blueberry',
                'description' => 'A blue blueberry',
                'price' => 99,
                'quantity' => 1030,
                'category' => 'Fruit',
                'user_id' => 1,
            )
        );
        DB::table('inventory')->insert(
            array(
                'name' => 'Boeing 787-8 Dreamliner',
                'description' => 'A wide-body jet airliner manufactured by Boeing Commercial Airplanes',
                'price' => 248300000,
                'quantity' => 1062,
                'category' => 'Aircraft',
                'user_id' => 1,
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
