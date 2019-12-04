<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('document_type_id')->nullable();
                $table->string('document_number')->nullable();
                $table->string('email')->unique();
                $table->string('first_name');
                $table->string('last_name')->nullable();
                $table->string('nickname')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password'); 
                $table->rememberToken();
                $table->string('provider_id')->nullable();
                $table->string('provider')->nullable();
                $table->boolean('blocked')->nullable()->default(0);
		$table->timestamps();
		$table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
