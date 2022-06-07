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
        Schema::create('classroom_registrars', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("raw_access_code");
            $table->string("access_code");
            $table->string("slug");
            $table->integer("creator_id");
            $table->string("creator_name");
<<<<<<< HEAD
            $table->string("description")->nullable();
            $table->integer("registrar_id");
=======
            $table->string("description");
            $table->integer("registrar_id");
            $table->string("registrar_name");
>>>>>>> 898aa7a (Classroom CRUD & Details)
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
        Schema::dropIfExists('classroom_registrars');
    }
};
