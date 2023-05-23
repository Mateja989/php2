<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "../templates/functions.php";
        

        try{
            $id = $_POST['id'];
            $active=1;
            $approveAd=approveAd($id,$active);

            if($approveAd){
                $response=["message"=>"Oglas je aktiviran."];
                echo json_encode($response);
                http_response_code(200);
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