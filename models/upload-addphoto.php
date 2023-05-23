<?php

$uploadDir='../assets/img/';
if(isset($_POST['adpictureBtn'])){

    require_once "../config/connection.php";
    require_once "../templates/functions.php";

    $id_ad=$_POST['ad']; 
    $fileName= $_FILES['adpicture']['name'];
    $tmpName= $_FILES['adpicture']['tmp_name'];

    $filePath=$uploadDir . $fileName;
    $pathForDB="assets/img/" . $fileName;


    $result=move_uploaded_file($tmpName,$filePath);
    if($result){
        $upload=uploadAdPicture($pathForDB,$id_ad);
        if($upload){
            header("location: ../propertie-page.php?idProp=$id_ad");
        }
    }
    else{
        exit(); 
    }
}
else{
    header('location: index.php');
}