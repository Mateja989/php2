<?php
    header('Content-type: application/json');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once "../config/connection.php";
        require_once "../templates/functions.php";

        try{
            if(isset($_POST['limit'])){
                $limit=$_POST['limit'];
            }
            else{
                $limit=0;
            }
            
           
            $objekat = [
                "grad" => isset($_POST['grad']) ? $_POST['grad'] : [],
                "tip" =>  isset($_POST['tip']) ? $_POST['tip'] : [],
                "struktura" =>  isset($_POST['struktura']) ? $_POST['struktura'] : [],
                "prazan" => isset($_POST['prazan'])? $_POST['prazan'] : "true",
            ];
           
            $realEstates=getAllProperties($objekat,$limit);
            $pictures=getAllPic();
            $brojStranica=vratiBrojStranica();


            echo json_encode([
                "realEstate"=>$realEstates,
                "picture"=>$pictures,
                "pages"=>$brojStranica
            ]);
            http_response_code(200);
        }
        catch(PDOException $exception){
            echo json_encode($exception);
            http_response_code(500);
        }
    }
    else{
        header('location: index.php');
    }

    
    
   
    
    
 