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
        Schema::create('deport_seeder', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('date', 40)->nullable();
            $table->double('PPMC_APAPA')->nullable();
            $table->double('NIPCO')->nullable();
            $table->double('NAVGAS')->nullable();
            $table->double('MATRIX')->nullable();
            $table->double('STOCKGAP')->nullable();
            $table->double('PRUDENT')->nullable();
            $table->double('RAIN_OIL')->nullable();
            $table->double('DOZZY')->nullable();
            $table->double('TECH_OIL')->nullable();
            $table->double('IIPLC')->nullable();
            $table->double('KHL')->nullable();
            $table->double('AA_RANO')->nullable();
            $table->double('SHAFA_ENERGY')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deport_seeder');
    }
};
