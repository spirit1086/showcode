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
        Schema::create('sms_user', function (Blueprint $table) {
            $table->id();
            $table->string('mobile',100);
            $table->string('sms',4);
            $table->dateTime('sms_created');
            $table->unsignedInteger('is_sms_verify')->nullable();
            $table->string('tmp_token',10)->nullable();
            $table->dateTime('tmp_token_created')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_user');
    }
};
