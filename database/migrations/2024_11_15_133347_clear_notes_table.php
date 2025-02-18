<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    // reset the notes table that gets FULL after hours of mock testing
    public function up() : void {
        DB::table('notes')->truncate();
        DB::statement('ALTER SEQUENCE notes_id_seq RESTART;');
    }
};
