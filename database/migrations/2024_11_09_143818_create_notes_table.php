<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void {
        Schema::create('notes', function (Blueprint $table) {
            // base
            $table->bigIncrements("id")->nullable(false);
            $table->timestamps();
            // raw input data -> img and api response
            $table->string("img_url");
            $table->text("extracted_data");
            // bool props
            $table->boolean("is_favourite")->default(false);
            $table->boolean("is_archived")->default(false);
            $table->boolean("is_edited")->default(false);
            $table->boolean("is_deleted")->default(false);
            // output data
            $table->text("markdown");
            $table->string("title");
            //foreign
            $table->integer("user_id")->nullable(false)->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void {
        Schema::dropIfExists('notes');
    }
};