<?php 
if(isset($_POST['send'])){

    require_once "../config/connection.php";
    require_once "../templates/functions.php";
    $email=$_POST['email'];
    $errorNum=0;
    $field="";
    $nameMssg="";
    $text="";


    if(!invalidEmail($email)){
        $nameMssg='emailError';
        $text='Email nije u dobrom formatu';
        setMessage($nameMssg,$text);
        $errorNum++;
        $field='emailValue';
        setMessage($field,$email);
    }

    if($errorNum!=0){
        header('location: ../index.php');
    }
    else{
        $result=newslatterInsert($email);
        if(!$result){
          header("location: ../index.php?error=Greška prilikom registracije");
          exit();
        }
        else{
          header('location: ../index.php');
        }
    }
}
else{
  header('location: ../index.php');
}