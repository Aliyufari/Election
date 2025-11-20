<?php

use App\Models\Pu;
use App\Models\Lga;
use App\Models\Role;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
                        $table->foreignIdFor(Role::class, 'role_id')->nullable()->constrained()->nullOnDelete();
                        $table->foreignIdFor(State::class, 'state_id')->nullable()->constrained()->nullOnDelete();
                        $table->foreignIdFor(Zone::class, 'zone_id')->nullable()->constrained()->nullOnDelete();
                        $table->foreignIdFor(Lga::class, 'lga_id')->nullable()->constrained()->nullOnDelete();
                        $table->foreignIdFor(Ward::class, 'ward_id')->nullable()->constrained()->nullOnDelete();
                        $table->foreignIdFor(Pu::class, 'pu_id')->nullable()->constrained()->nullOnDelete();
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
