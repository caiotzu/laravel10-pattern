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
        Schema::create('admin_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id')->unsigned()->nullable(false);
            $table->foreign('role_id')
                ->references('id')
                ->on('admin_roles');
            $table->bigInteger('permission_id')->unsigned()->nullable(false);
            $table->foreign('permission_id')
                ->references('id')
                ->on('admin_permissions');
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
        Schema::dropIfExists('admin_role_permissions');
    }
};
