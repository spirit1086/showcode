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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->unsignedInteger('city_id')->nullable();
            $table->string('street',255)->nullable();
            $table->unsignedInteger('house_number')->nullable();
            $table->unsignedInteger('apt')->nullable();
            $table->unsignedInteger('school_id')->nullable();
            $table->unsignedInteger('class')->nullable();
            $table->string('letter',1)->nullable();
            $table->date('birthday')->nullable();
            $table->text('photo')->nullable();
            $table->string('mobile');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
