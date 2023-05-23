<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "../templates/functions.php";
        

        try{
            $id = $_POST['id'];
            $deleteAd=adDelete($id);
            $active=1;
            $adList=getFullList($active);

            if($deleteAd){
                echo json_encode($adList);
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