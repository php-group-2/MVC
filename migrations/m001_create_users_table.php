<?php

use App\core\MySqlDatabase;

class CreateUsersTable
{
    public static function up()
    {
        MySqlDatabase::do()->db->exec(
            "CREATE TABLE users (
                id INT NOT NULL AUTO_INCREMENT,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                name VARCHAR(255),
                phone VARCHAR(255),
                PRIMARY KEY (id)
            );"
        );
    }
    public static function down()
    {
        MySqlDatabase::do()->db->exec(
            "DROP TABLE users;"
        );
    }
}
