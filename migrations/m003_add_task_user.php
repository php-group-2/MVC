<?php

use App\core\MySqlDatabase;

class AddTaskUser
{
    public static function up()
    {
        MySqlDatabase::do()->db->exec(
            "ALTER TABLE tasks ADD user_id INT NOT NULL;
             ALTER TABLE tasks ADD CONSTRAINT tasks_user_fk
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;"
        );
    }
    public static function down()
    {
        MySqlDatabase::do()->db->exec(
            "ALTER TABLE tasks DROP tasks_user_fk;
             ALTER TABLE tasks DROP user_id;"
        );
    }
}
