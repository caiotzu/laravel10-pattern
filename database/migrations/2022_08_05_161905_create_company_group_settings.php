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
        Schema::create('company_group_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_group_id')->unsigned()->nullable(false);
            $table->foreign('company_group_id')
                ->references('id')
                ->on('company_groups');
            $table->string('key', 50);
            $table->text('value');
            $table->text('description')->nullable(true);
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
        Schema::dropIfExists('company_group_settings');
    }
};
