<?php 

    if ($_SERVER['REQUEST_METHOD'] !== "POST"){
        echo "Request method not accepted";
        exit;
    }

    if (empty($_POST["username"]) || empty($_POST["password"])){
        echo json_encode(["ERROR" => "Username and password is required"]);
        exit;
    }

    include_once "db.php";

    $db = DB::connect();
    $rs = $db->prepare("SELECT * FROM users where username = :username");
    $rs->bindParam(":username", $_POST["username"]);
    $rs->execute();
    $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

    if (count($obj) <= 0){
        echo json_encode(["ERROR" => "Username not exists"]);
        exit;
    }

    if (strcmp($obj[0]["password"], $_POST["password"]) !== 0){
        echo json_encode(["ERROR" => "Incorret password"]);
        exit;
    }

    echo json_encode(["ERROR" => "User loggined"]);
?>