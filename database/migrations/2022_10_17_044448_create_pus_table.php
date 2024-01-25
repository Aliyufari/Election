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
        Schema::create('pus', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->foreignId('state_id')
                  ->constrained('states')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('zone_id')
                  ->constrained('zones')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('lga_id')
                  ->constrained('lgas')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('ward_id')
                  ->constrained('wards')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('description')->nullable();
            $table->bigInteger('registration')->nullable()->default(0);
            $table->bigInteger('accreditation')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pus');
    }
};
