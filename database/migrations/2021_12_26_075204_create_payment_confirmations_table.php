<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentConfirmationsTable extends Migration
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
            $table->string('code')->unique();
            $table->string('type', 100);
            $table->decimal('amount', 15,2);
            $table->string('status', 15);
            $table->text('description')->nullable();
            $table->string('created_id');
            $table->boolean('need_confirmation')->default(false);
            $table->string('path_to_file')->nullable();
            $table->integer('confirmed_by')->nullable();
            $table->integer('declined_by')->nullable();
            $table->date('confirmed_at')->nullable();
            $table->date('declined_at')->nullable();
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
