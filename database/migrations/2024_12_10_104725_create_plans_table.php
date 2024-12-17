<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Plan name
            $table->decimal('price', 8, 2); // Plan price with 2 decimal points
            $table->string('icon'); // Plan icon (use the icon class, e.g., 'bi bi-star')
            $table->string('color')->nullable(); // Plan color (optional)
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
