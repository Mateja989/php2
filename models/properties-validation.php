<?php
header("Content-type: application/json");
if(isset($_POST["btn"])){

    try{
        require_once "../config/connection.php";
        require_once "../templates/functions.php";
    
        $name = $_POST['propertieName'];
        $city = $_POST['city'];
        $transaction = $_POST['transaction'];
        $type = $_POST['type'];
        $description=$_POST['description'];
        $price=$_POST['price'];
        $agent=$_POST['agent'];
        $response = "";
    
        $specObj=$_POST['specifikacije'];
        $upis = insertPropertie($description,$transaction,$agent,$city,$price,$type,$name);
 
        if($upis) { 
            $response = ["lokacija" => "profile.php"];
            $propertieId=lastIndexProperties();
            foreach($specObj as $spec){
                insertValueSpecification($propertieId,intval($spec['id']),$spec['vrednost']);
            }
            echo json_encode($response);
            http_response_code(201);
        }
        else{
            http_response_code(300);
        }

    }
    catch(PDOException $exception){
        echo json_encode($exception);
        http_response_code(500);
    }

    
}
else{
    header("location: index.php");
}

