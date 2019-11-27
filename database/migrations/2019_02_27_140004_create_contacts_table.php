<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id')->nullable();
                $table->unsignedInteger('company_id')->nullable();
                $table->string('slug')->nullable();
                $table->unsignedInteger('contactable_id')->nullable();
                $table->string('contactable_type')->nullable();
                $table->string('email')->nullable();
                $table->string('bio')->nullable();
                $table->string('position')->nullable();
                $table->string('company_name')->nullable();
                $table->string('mobile')->nullable();
                $table->string('phone')->nullable();
                $table->string('fax')->nullable();
                $table->string('website')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
