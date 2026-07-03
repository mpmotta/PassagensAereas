<?php
namespace App\Config;
use PDO;
class Conexao {
    public static function getConnection() {
        $host = "localhost";
        $dbname = "senactur";
        $username = "root";
        $password = "";
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
