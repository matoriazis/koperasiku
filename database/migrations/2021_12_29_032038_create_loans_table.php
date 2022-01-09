<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('type', 15);
            $table->decimal('amount', 15, 2);
            $table->decimal('loan_service', 15,2);
            $table->decimal('total', 15, 2);
            $table->text('description')->nullable();
            $table->decimal('installment_per_month', 15,2);
            $table->integer('total_month');
            $table->boolean('is_settled')->default(false);
            $table->integer('created_id');
            $table->integer('confirmed_by')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->integer('declined_by')->nullable();
            $table->dateTime('declined_at')->nullable();
            $table->text('declined_reason')->nullable();
            $table->boolean('is_confirmed')->default(false);
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
        Schema::dropIfExists('loans');
    }
}
