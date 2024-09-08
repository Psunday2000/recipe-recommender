<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPreferencesTable extends Migration
{
    public function up()
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key referencing users table
            $table->string('spice_level');
            $table->string('price_range');
            $table->timestamps(); // Created_at and Updated_at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_preferences');
    }
}
