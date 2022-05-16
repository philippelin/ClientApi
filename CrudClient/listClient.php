<?php 
    require_once ('database.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');


    global $conn;
    $sql = "SELECT * FROM client";
    $stmt = $conn->query($sql);

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo(json_encode($res));
?>