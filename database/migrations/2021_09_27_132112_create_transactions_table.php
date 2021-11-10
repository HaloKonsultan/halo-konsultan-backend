<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->string('external_id')->nullable();
            $table->string('status_invoice')->nullable();
            $table->string('status_disbursment')->nullable();
            $table->string('amount')->nullable();
            $table->string('invoice_url')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
