<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUserStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop procedures if they exist (safe to rerun migration)
        DB::unprepared('
            DROP PROCEDURE IF EXISTS create_user;
            DROP PROCEDURE IF EXISTS get_user_by_id;
            DROP PROCEDURE IF EXISTS get_all_users;
            DROP PROCEDURE IF EXISTS update_user;
            DROP PROCEDURE IF EXISTS delete_user;
        ');

        // Create procedure to insert a new user
        DB::unprepared('
            CREATE PROCEDURE create_user (
                IN p_first_name VARCHAR(100),
                IN p_last_name VARCHAR(100),
                IN p_email VARCHAR(150)
            )
            BEGIN
                INSERT INTO users (first_name, last_name, email, created_at, updated_at)
                VALUES (p_first_name, p_last_name, p_email, NOW(), NOW());
                SELECT LAST_INSERT_ID() AS new_user_id;
            END
        ');

        // Create procedure to fetch a user by id
        DB::unprepared('
            CREATE PROCEDURE get_user_by_id (
                IN p_id INT
            )
            BEGIN
                SELECT * FROM users WHERE id = p_id;
            END
        ');

        // Create procedure to fetch all users
        DB::unprepared('
            CREATE PROCEDURE get_all_users ()
            BEGIN
                SELECT * FROM users ORDER BY id;
            END
        ');

        // Create procedure to update user by id
        DB::unprepared('
            CREATE PROCEDURE update_user (
                IN p_id INT,
                IN p_first_name VARCHAR(100),
                IN p_last_name VARCHAR(100),
                IN p_email VARCHAR(150)
            )
            BEGIN
                UPDATE users
                SET first_name = p_first_name,
                    last_name = p_last_name,
                    email = p_email,
                    updated_at = NOW()
                WHERE id = p_id;
                SELECT ROW_COUNT() AS affected_rows;
            END
        ');

        // Create procedure to delete user by id
        DB::unprepared('
            CREATE PROCEDURE delete_user (
                IN p_id INT
            )
            BEGIN
                DELETE FROM users WHERE id = p_id;
                SELECT ROW_COUNT() AS affected_rows;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS create_user;
            DROP PROCEDURE IF EXISTS get_user_by_id;
            DROP PROCEDURE IF EXISTS get_all_users;
            DROP PROCEDURE IF EXISTS update_user;
            DROP PROCEDURE IF EXISTS delete_user;
        ');
    }
}
