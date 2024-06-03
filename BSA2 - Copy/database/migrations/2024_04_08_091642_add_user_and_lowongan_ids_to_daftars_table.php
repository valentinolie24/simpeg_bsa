<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftars', function (Blueprint $table) {
            // Tambahkan kolom User ID
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Tambahkan kolom Lowongan ID
            $table->unsignedBigInteger('lowongan_id')->nullable();
            $table->foreign('lowongan_id')->references('id')->on('lowongans')->onDelete('cascade');
        });
    }    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daftars', function (Blueprint $table) {
            // Drop kolom User ID
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
    
            // Drop kolom Lowongan ID
            $table->dropForeign(['lowongan_id']);
            $table->dropColumn('lowongan_id');
        });
    }
    
};
