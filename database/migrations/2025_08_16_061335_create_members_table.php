<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('father_name'); 
            $table->string('voter_id'); 
            $table->string('gender'); 
            $table->string('village'); 
            $table->string('post'); 
            $table->string('panchayath'); 
            $table->string('mandal'); 
            $table->string('state'); 
            $table->string('voter_card')->nullable()->default('N/A'); 
            $table->timestamps();
        });
    }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
