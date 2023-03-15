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
        Schema::create('company_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable(false);
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->bigInteger('county_id')->unsigned()->nullable(false);
            $table->foreign('county_id')
                ->references('id')
                ->on('counties');
            $table->boolean('active')->default(true);
            $table->boolean('main')->default(false);
            $table->string('zip_code', 8);
            $table->string('address', 100);
            $table->string('number', 5);
            $table->string('neighborhood', 100);
            $table->string('complement', 50)->nullable(true);
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
        Schema::dropIfExists('company_addresses');
    }
};
