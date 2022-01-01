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
            $table->foreignId('category_id')->nullable()->constrained('categories')->onUpdate('cascade');
            $table->string('description', 1000)->nullable();
            $table->string('gender')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('consultation_price')->nullable();
            $table->bigInteger('chat_price')->nullable();
            $table->string('photo')->nullable();
            $table->integer('likes_total')->nullable();
            $table->string('device_token')->nullable();
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
