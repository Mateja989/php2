<?php
    if(isset($_GET['vkey'])){
        require_once "../config/connection.php";
        require_once "../templates/functions.php";
        $vkey=$_GET['vkey'];
        $result=verificationUser($vkey);
        if($result){
            $update=updateUser($vkey);
            if($update){
                header('Location: ../log.php');
            }
            else{
                header('Location: ../index.php');
                exit();
            }
        }
        else{
            header('location: index.php');
            exit();
        }
    }
    else{
        header('location: index.php');
        exit();
    }
    
?>
