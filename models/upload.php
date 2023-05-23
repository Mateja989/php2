<?php

$uploadDir='../assets/img/';
if(isset($_POST['upload'])){
   

    require_once "../config/connection.php";
    require_once "../templates/functions.php";

    $id=$_POST['user']; 
    $fileName= $_FILES['userpicture']['name'];
    $tmpName= $_FILES['userpicture']['tmp_name'];


    $filePath=$uploadDir . $fileName;
    $pathForDB="assets/img/" . $fileName;


    $result=move_uploaded_file($tmpName,$filePath);
    if($result){
        $upload=uploadProfilePicture($pathForDB,$id);
        if($upload){
            header("location: ../profile.php");
        }
    }
    else{
        exit();
    }
}
else{
    header('location: index.php');
}