<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "../templates/functions.php";

        try{
            $id = $_POST['id'];
            $specifications = "";
            if($id == ""){
                
            }
            else{
                $specifications = getSpecificationType($id);
            }
            echo json_encode($specifications);
            http_response_code(200);
        }
        catch(PDOException $exception){
            echo json_encode($exception);
            http_response_code(500);
        }
    }
    else{
        header('location: index.php');
        http_response_code(404);
    }
?>