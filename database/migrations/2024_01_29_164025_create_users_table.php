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
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->enum('gender', ['male','female'])->nullable();
            $table->boolean('active')->default(true);
            $table->integer('generation')->default(date('Y'))->nullable();
            $table->enum('role', ['super_admin','admin','user'])->default('user');
            $table->text('address')->nullable();
            $table->dateTime('join_date')->default(now());

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('restrict');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('restrict');
            
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
