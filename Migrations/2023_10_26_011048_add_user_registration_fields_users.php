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
        Schema::table('users',function (Blueprint $table){
            $table->unsignedInteger('relation_id')->nullable();
            $table->unsignedInteger('gender_id')->nullable();
            $table->string('fast_code',255)->nullable();
            $table->unsignedInteger('save_interface')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function (Blueprint $table){
            $table->dropColumn('relation_id');
            $table->dropColumn('gender_id');
            $table->dropColumn('fast_code');
            $table->dropColumn('save_interface');
        });
    }
};
