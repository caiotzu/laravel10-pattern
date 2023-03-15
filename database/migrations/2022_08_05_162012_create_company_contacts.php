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
        Schema::create('company_contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable(false);
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->enum('type', ['T', 'E'])->comment('T - Telefone, E - E-mail');
            $table->string('value', 100);
            $table->boolean('active')->default(true);
            $table->boolean('main')->default(false);
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
        Schema::dropIfExists('company_contacts');
    }
};
