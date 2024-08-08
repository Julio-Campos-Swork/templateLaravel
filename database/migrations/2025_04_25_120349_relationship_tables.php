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
        Schema::table('login_register', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
        });
        Schema::table('error_log', function (Blueprint $table){
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
        });
        Schema::table('users', function (Blueprint $table){
            $table->foreign('id_user_type')->references('id')->on('user_type')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
