<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->char('code', 20)->nullable();
            $table->integer('user_id');
            $table->string('fullname', 50);
            $table->string('job_dept', 50);
            $table->text('address');
            $table->string('phone', 15);
            $table->decimal('salary', 15,2);
            $table->string('status');
            $table->boolean('is_activated')->default(false);
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
        Schema::dropIfExists('profiles');
    }
}
