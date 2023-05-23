<?php
    session_start();
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "../templates/functions.php";

        try{
            $id = $_POST['id'];
            $deleteUser=deleteProfile($id);
            if($deleteUser){
                unset($_SESSION['user']);
                unset($_SESSION['agent']); 
                $location=["location"=>"index.php"];
                echo json_encode($location);
                http_response_code(200);
            }else{
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