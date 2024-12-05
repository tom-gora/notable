<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // props
            $table->string('name');
            $table->boolean('is_deleted')->default(false);
            //foreign
            $table->integer('user_id')->nullable(false)->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('note_id')->nullable(false)->unsigned();
            $table->foreign('note_id')->references('id')->on('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void {
        Schema::dropIfExists('collections');
    }
};
