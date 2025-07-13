<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateGetAllUsersProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS get_all_users');

        DB::unprepared('
            CREATE PROCEDURE get_all_users(IN limit_val INT, IN offset_val INT)
            BEGIN
                SELECT * FROM users ORDER BY id LIMIT limit_val OFFSET offset_val;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS get_all_users');

        DB::unprepared('
            CREATE PROCEDURE get_all_users()
            BEGIN
                SELECT * FROM users ORDER BY id;
            END
        ');
    }
}
