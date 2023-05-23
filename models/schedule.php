<?php 
    if(isset($_POST['scheduleBtn'])){

        require_once "../config/connection.php";
        require_once "../templates/functions.php";

        $date=$_POST['dateSchedule'];
        $userId=$_POST['user'];
        $agent=$_POST['agent'];
        $propertie=$_POST['propertie'];
        $scheduleId=$_POST['schedule-ddl'];

       $existAppointment=existAppointmentForAgent($scheduleId,$date,$agent);

        if($existAppointment){
            header('location: ../index.php?postoji');
            exit();
        }

        /*$existAppointmentForEstate=existAppointmentForEstate($scheduleId,$date,$propertie);
        if($existAppointment){
            header('location: ../index.php?postoji');
            exit();
        }*/

        /*$insertAppointment=insertAppointment($date,$userId,$agent,$propertie,$scheduleId);

        if($insertAppointment){
            header('location: ../profile.php');
        }*/

    }
    else{
        header('location: ../index.php');
    }