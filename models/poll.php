<?php
    session_start();
    if(isset($_POST['btn-poll'])){
        include "../config/connection.php";
        include "../templates/functions.php";
        $answer1=isset($_POST['question1'])?$_POST['question1']:[];
        $answer2=isset($_POST['question2'])?$_POST['question2']:[];
        $idUser=$_SESSION['user']->id_korisnik;
        $errorCounter;
        if(empty($answer1) || empty ($answer2)){
            $_SESSION['error']="Morate na oba pitanja dati odgovor.";
            $errorCounter++;
        }else{
            $existAnswer=existAnswer($idUser);
            if(count($existAnswer)!=0){
                $_SESSION['exist']="Vec se uspesno odgovorili na nasu anketu.";
                $errorCounter++;
            }
            else{
                if($errorCounter==0){
                    $pollAnswered1=answeredPoll($idUser,$answer1);
                    $pollAnswered2=answeredPoll($idUser,$answer2);
                    if($pollAnswered1 && $pollAnswered2){
                    $_SESSION['success']="Uspesno ste dali odgovore na nasu anketu.";
                    }
                }
            }
        }
        header('location: ../poll.php');

    }
    else{
        header('location: ../index.php'); 
    }
?>