<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('gender')->nullable();
            $table->string('location')->nullable();
            $table->bigInteger('consultation_price')->nullable();
            $table->bigInteger('chat_price')->nullable();
            $table->string('photo')->nullable();
            $table->integer('total_experiences')->nullable();
            $table->integer('likes_total')->nullable();
            $table->string('firebase_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultants');
    }
}
