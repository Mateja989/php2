<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "../templates/functions.php";

        try{
            $id = $_POST['id'];
            $deleteMessage=deleteMessage($id);
            $MessageList=getAll('kontakt');

            if($deleteMessage){
                echo json_encode($MessageList);
                http_response_code(201);
            }else{
                $response=['message'=>'Nije prosledjen dobar parametar.'];
                echo json_encode($response);
                http_response_code(300);
            }

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