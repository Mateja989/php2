<?php
    header('Content-type: application/json');
    
        require_once "../config/connection.php";
        require_once "../templates/functions.php";

        try{
      
            $pictures=getAllPic();

            echo json_encode($pictures);
            http_response_code(200);
        }
        catch(PDOException $exception){
            echo json_encode($exception);
            http_response_code(500);
        }
    
