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
        Schema::create('forum_student_file_attachments', function (Blueprint $table) {
            $table->id();
            $table->text("file")->nullable();
            $table->foreignId("forum_id");
            $table->integer("sender_id");
            $table->string("sender_name");
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
        Schema::dropIfExists('forum_student_file_attachments');
    }
};
