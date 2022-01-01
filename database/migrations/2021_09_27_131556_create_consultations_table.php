<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('description',1000)->nullable();
            $table->string('title')->nullable();
            $table->bigInteger('consultation_price')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_confirmed')->nullable();
            $table->string('preference')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('conference_link')->nullable();
            $table->string('message',1000)->nullable();
            $table->integer('review')->default(0);
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
        Schema::dropIfExists('consultations');
    }
}
