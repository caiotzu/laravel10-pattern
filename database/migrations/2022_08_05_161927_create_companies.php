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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_group_id')->unsigned()->nullable(false);
            $table->foreign('company_group_id')
                ->references('id')
                ->on('company_groups');
            $table->bigInteger('headquarter_id')->nullable(true);
            $table->string('cnpj', 14);
            $table->string('trade_name', 60);
            $table->string('company_name', 60);
            $table->string('state_registration', 9);
            $table->string('municipal_registration', 11);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('companies');
    }
};
