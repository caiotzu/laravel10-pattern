<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id')->unsigned()->nullable(false);
            $table->foreign('role_id')
                ->references('id')
                ->on('admin_roles');
            $table->string('name', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->boolean('active')->default(true);
            $table->string('remember_token', 100)->nullable(true);
            $table->string('avatar')->nullable(true);
            $table->timestamps($precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
};
