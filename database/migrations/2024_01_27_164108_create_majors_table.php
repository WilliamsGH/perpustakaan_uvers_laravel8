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
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->string('name');
            $table->char('alias', 5);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majors');
    }
};
