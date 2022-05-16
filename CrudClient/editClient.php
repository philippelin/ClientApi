<?php
    require_once ('../database.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');


if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["telephone"])){

    $nom = htmlspecialchars($_POST["nom"]);
    $prenoms = htmlspecialchars($_POST["prenom"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $idClient = $_GET['id_client'];

    global $conn;
    $sql = "UDPATE client SET nom =:nom, prenom =:prenoms, telephone =:telephone WHERE id_client =:id";
    $stmt = $conn->prepare($sql);

    $stmt -> bindParam(':nom',$nom, PDO::PARAM_STR);
    $stmt -> bindParam(':prenoms',$prenoms, PDO::PARAM_STR);
    $stmt -> bindParam(':telephone',$telephone, PDO::PARAM_STR);
    $stmt -> bindParam(':id',$idClient, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->error) {
        echo "FAILURE!!! " . $stmt->error;
      }
    else echo "Updated {$stmt->affected_rows} rows";
    
    return $conn->lastInsertId();
    

}
    

?>