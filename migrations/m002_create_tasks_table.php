<?php

use App\core\MySqlDatabase;

class CreateTasksTable
{
    public static function up()
    {
        MySqlDatabase::do()->db->exec(
            "CREATE TABLE tasks (
                id INT NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                deadline DATETIME,
                color VARCHAR(255),
                status TINYINT DEFAULT 0,
                PRIMARY KEY (id)
            );"
        );
    }
    public static function down()
    {
        MySqlDatabase::do()->db->exec(
            "DROP TABLE tasks;"
        );
    }
}
