<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('no_ktp', 20)->unique()->nullable();
            $table->decimal('saving_wajib', 15,2)->nullable();
            $table->decimal('saving_pokok', 15,2)->nullable();
            $table->decimal('saving_sukarela', 15,2)->nullable();
            $table->decimal('total', 15,2)->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['no_ktp', 'saving_wajib', 'saving_pokok', 'saving_sukarela', 'birth_place', 'birth_date']);
        });
    }
}
