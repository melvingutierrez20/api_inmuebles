<?php
namespace App\Models;

use PDO;

class Inmueble
{
    public static function getAll()
    {
        $db = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME,
            DB_USER,
            DB_PASS,
            DB_OPTIONS
        );
        
        return $db->query("SELECT * FROM Inmuebles")->fetchAll();
    }
}