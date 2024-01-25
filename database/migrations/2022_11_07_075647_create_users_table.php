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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('role')->default('User');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('lga_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('pu_id')->nullable();
            $table->string('company')->nullable();
            $table->string('job')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('state_id')
                    ->references('id')
                    ->on('states')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            $table->foreign('zone_id')
                    ->references('id')
                    ->on('zones')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            $table->foreign('lga_id')
                    ->references('id')
                    ->on('lgas')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            $table->foreign('ward_id')
                    ->references('id')
                    ->on('wards')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            $table->foreign('pu_id')
                    ->references('id')
                    ->on('pus')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
        });
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
};
