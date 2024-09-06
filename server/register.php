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
    $rs->bindParam(":username", $_POST['username'] );
    $rs->execute();
    $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

    if (count($obj) > 0){
        echo json_encode(["ERROR" => "Username already exists"]);
        exit;
    }

    $id = rand(100000, 999999);

    $rs = $db->prepare("INSERT INTO users (id, username, password) VALUES (:id, :username, :password)");
    $rs->bindParam(":id", $id );
    $rs->bindParam(":username", $_POST['username']);
    $rs->bindParam(":password", $_POST['password']);
    $obj = $rs->execute();

    if (!$obj){
        echo json_encode(["ERROR" => "Register error"]);
        exit;
    }

    echo json_encode(["SUCCESS" => "User registered"]);
?>