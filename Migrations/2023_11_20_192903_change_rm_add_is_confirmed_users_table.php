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
        Schema::table('users',function (Blueprint $table) {
            $table->dropColumn('sms_created');
            $table->dropColumn('is_sms_verify');
            $table->dropColumn('tmp_token');
            $table->dropColumn('tmp_token_created');
            $table->dropColumn('sms');
            $table->unsignedInteger('is_confirmed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function (Blueprint $table) {
            $table->string('sms',4);
            $table->dateTime('sms_created');
            $table->unsignedInteger('is_sms_verify')->nullable();
            $table->string('tmp_token',10)->nullable();
            $table->dateTime('tmp_token_created')->nullable();
            $table->dropColumn('is_confirmed');
        });
    }
};
