<?php
    include "templates/head.php";
    include "templates/navigation.php";
    
 if(isset($_POST['btn-agent-reg'])){

    $licence=$_POST['licence'];
    $phone=$_POST['phone'];
    $uId=$_POST['uId'];

    $licenceReg="/^[\d]{13}$/";
    $phoneReg="/^06[\d]{7,8}$/";
    $error=[];


    if(!invalidInput($phone,$phoneReg)){
        $error['phoneError']="Telefon nije u dobrom formatu mora poceti sa 06**.";
    }
    if(!invalidInput($licence,$licenceReg)){
        $error['licenceError']="Broj dozvole nije u dobrom formatu.";
    }
    if(!existLicenceNumber($licence)){
        $error['licenceExist']="Broj dozvole vec postoji u bazi.";
    }

    var_dump($error);

    if(count($error)==0){
        $result=registrationAgent($licence,$phone,$uId);
        if(!$result){
                $error['Error']="Greska prilikom upisa.";
        }
        else{
                $success['uspeh']="Uspesno ste poslali zahtev,admin ce pregledati u naredna 24 sata.";
        }
    }
}
?>

<div class="container rounded bg-white pd-3 mt-5 mb-5">
    <div class="row mt-5">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?= $_SESSION['user']->korisnicko_ime ?></span><span class="text-black-50"><?= $_SESSION['user']->mail_adresa ?></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Podaci o korisničkom nalogu</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Ime</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['user']->ime ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Prezime</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['user']->prezime ?>" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Email</label>
                        <input type="text" class="form-control"  value="<?= $_SESSION['user']->mail_adresa ?>" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Korisnicko ime</label>
                        <input type="text" class="form-control"  value="<?= $_SESSION['user']->korisnicko_ime ?>" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Uloga</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['user']->naziv_uloga ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="agent-form">
                <div class="d-flex justify-content-between align-items-center experience">
                    <h4>Agent podaci</h4>
                </div>
                <br>
                <div class="col-md-12">
                    <label class="labels">Broj dozvole</label>
                    <input type="text" class="form-control" id="licence" value="<?= isset($licence)?$licence : ""?>" name="licence" >
                    <?php if(isset($error['licenceError'])): ?>
                        <p class="error"><?= $error['licenceError'] ?></p>
                    <?php endif; ?>
                    <?php if(isset($error['licenceExist'])): ?>
                        <p class="error"><?= $error['licenceExist'] ?></p>
                    <?php endif; ?>
                    <p class="error hidden">Broj dozvole mora sadrzati 13 cifara</p>
                </div> 
                <br>
                <div class="col-md-12">
                    <label class="labels">Broj telefona</label>
                    <input type="text" class="form-control" id="phone" value="<?= isset($phone)?$phone :""?>"  name="phone">
                    <?php if(isset($error['phoneError'])): ?>
                        <p class="error"><?= $error['phoneError'] ?></p>
                    <?php endif; ?>
                    <p class="error hidden">Broj telefona mora biti u formatu 060/123****</p>
                </div>
                <input type="hidden" value="<?= $_SESSION['user']->id_korisnik ?>" id="uId" name="uId" readonly>
                <div class="mt-5 text-center">
                    <input type="submit" value="Sacuvaj izmene" class="btn btn-primary" id="btn-agent-reg" name="btn-agent-reg"/>
                    <?php if(isset($success['uspeh'])): ?>
                       <p class="success"><?= $success['uspeh'] ?></p>
                    <?php endif; ?>
                </div>
                </form> 
                <?php
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php
    include "templates/footer.php";
?>
