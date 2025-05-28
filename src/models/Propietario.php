<?php
namespace App\Models;

use PDO;

class Propietario
{
    public static function getById($id)
    {
        $db = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME,
            DB_USER,
            DB_PASS,
            DB_OPTIONS
        );
        
        $stmt = $db->prepare("SELECT * FROM Propietarios WHERE idPropietario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}