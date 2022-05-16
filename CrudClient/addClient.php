<?php

require_once ('database.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["telephone"])){

    $nom = htmlspecialchars($_POST["nom"]);
    $prenoms = htmlspecialchars($_POST["prenom"]);
    $telephone = htmlspecialchars($_POST["telephone"]);

    global $conn;
    $sql = "INSERT INTO client (nom, prenoms, telephone) VALUES (:nom, :prenoms, :telephone)";
    $stmt = $conn->prepare($sql);

    $stmt -> bindParam(':nom',$nom, PDO::PARAM_STR);
    $stmt -> bindParam(':prenoms',$prenoms, PDO::PARAM_STR);
    $stmt -> bindParam(':telephone',$telephone, PDO::PARAM_STR);

    $stmt->execute();
    
    echo "Client enregistré";

    $id = $conn->lastInsertId();


    //Communication vers le service Adresse pour envoyer
    //l'id du client qui servira a la fonction addAdresse
    $data= array("id" => "$id");
    $json_data = json_encode($data);
    $url = "http://localhost/CrudAdresse/addAdresse.php"; //localhost car testé en local mais devra
            //etre remplacé par le chemin vers le service Crud Adresse de la machine connecté en réseau
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POSTREDIR, 3);

    $result = curl_exec($curl);

    if($result === false){
        var_dump(curl_error($curl));
    }
    else{
        var_dump(curl_getinfo($curl, CURLINFO_HTTP_CODE));
    }
    curl_close($curl);
    
    //-------------------------------------------------------------------------------------------------------
    //Communication vers le service Devis pour envoyer
    //l'id du client qui servira a la fonction addDevis
    $url1 = "http://localhost/CrudDevis/addDevis.php"; //localhost car testé en local mais devra
            //etre remplacé par le chemin vers le service Crud Devis de la machine connecté en réseau
    
    $curl1 = curl_init($url1);
    curl_setopt($curl1, CURLOPT_POST, true);
    curl_setopt($curl1, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl1, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);

    $result1 = curl_exec($curl1);
  
    if($result1 === false){
        var_dump(curl_error($curl1));
    }
    else{
        var_dump($curl_getinfo($curl1, CURLINFO_HTTP_CODE));
    }
    curl_close($curl1);
   

}
    

?>
