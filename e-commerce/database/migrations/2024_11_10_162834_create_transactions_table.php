<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 10);
            $table->string('order_id', 100);
            $table->string('payment_type', 100)->nullable();
            $table->integer('gross_amount');
            $table->timestamp('transaction_time');
            $table->enum('transaction_status', ['pending', 'settlement', 'cancel', 'expire', 'succes']);
            $table->text('metadata')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
