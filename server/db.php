<?php 
class DB{
    public static function connect(){
        $host = "localhost";
        $user = "root";
        $pass = "";
        $database = "tcc";

        return new PDO("mysql:host={$host};dbname={$database};charset=UTF8;", $user, $pass);
    }
}

?>