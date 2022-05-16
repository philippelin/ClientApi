<?php 
    require_once ('database.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    if(isset ($_GET['id_client']))
    {
        $id = $_GET['id_client'];
        try{
            global $conn;

            $sqlSuppr = " DELETE FROM client WHERE id= '" .$id."' ";
            $conn->exec($sqlSuppr);

            echo "Client bien supprimé";  
            
        }catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

    }
   