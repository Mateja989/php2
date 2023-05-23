<?php
    include "templates/head.php";
    $idUser=$_SESSION['user']->id_korisnik;
    $user=getUser($idUser);
    
    if(isset($_POST['edit-btn'])){
        $id=$idUser;
        $firstName=$_POST['first-name'];
        $lastName=$_POST['last-name'];
        $email=$_POST['email'];
        $username=$_POST['username'];
        $fileName= $_FILES['picture']['name'];
        $tmpName= $_FILES['picture']['tmp_name'];
        $error=[];

        $nameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/";
        $surnameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/";
        $usernameReg="/^([a-z]{1})[a-z0-9]{4,29}$/";
        

    
        if(!invalidInput($firstName,$nameReg)){
            $error['firstName']="Ime nije u dobrom formatu mora poceti velikim slovom.";
        }
        if(!invalidInput($lastName,$surnameReg)){
            $error['lastName']="Prezime nije u dobrom formatu mora poceti velikim slovom.";
        }
        if(!invalidInput($username,$usernameReg)){
            $error['username']="Korisnicko ime moze sadrzati samo mala slova i brojeve i najmanje 5 karaktera.";
        }
        if(!invalidEmail($email)){
            $error['email']="Mejl nije u dobrom formatu.";
        }

        


        if($fileName!=""){
            $uploadDir='../assets/img/';
            $filePath=$uploadDir . $fileName;
            $pathForDB="assets/img/" . $fileName;
            move_uploaded_file($tmpName,$filePath);

            if(count($error)==0){
                $editProfile=updateProfileForAdmin($id,$firstName,$lastName,$username,$email,$pathForDB);
                if($editProfile){
                    $success['success']="Uspesno ste sacuvali izmene.";
                }
            }
        }
        else{
            if(count($error)==0){
                $profilePicture=existProfilePicture($id);
                $pathForDB=$profilePicture->profilna_slika;
                $editProfile=updateProfileForAdmin($id,$firstName,$lastName,$username,$email,$pathForDB);
                if($editProfile){
                    $success['success']="Uspesno ste sacuvali izmene.";
                }
            }
        }
    }

?>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Moj profil</h2>
                    </div>
                    <div class="container rounded bg-white mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-4 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" src="<?= isset($user->profilna_slika)? "../".$user->profilna_slika : '../assets/img/slika222.jpg' ?>" width="90"><span class="font-weight-bold"><?= $user->korisnicko_ime ?></span><span class="text-black-50"><?= $user->mail_adresa ?></span></div>
                            </div>
                         
                            <div class="col-md-8">
                                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" 
                                enctype='multipart/form-data'>
                                <div class="p-3 py-5">
                                <?php if(isset($success['success'])): ?>
                                        <p class="success"><?= $success['success'] ?></p>
                                    <?php endif; ?>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label>Ime</label>
                                            <input type="text" class="form-control" name="first-name" value="<?= isset($firstName)?$firstName :$user->ime?>" />
                                            <?php if(isset($error['firstName'])): ?>
                                                <p class="errorText"><?= $error['firstName'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Prezime</label>
                                            <input type="text" class="form-control" name="last-name" value="<?= isset($lastName)?$lastName :$user->prezime?>"/>
                                            <?php if(isset($error['lastName'])): ?>
                                                <p class="errorText"><?= $error['lastName'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label>Email adresa</label>
                                            <input type="text" class="form-control" name="email" value="<?= isset($email)?$email :$user->mail_adresa?>">
                                            <?php if(isset($error['email'])): ?>
                                                <p class="errorText"><?= $error['email'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Korisnicko ime</label>
                                            <input type="text" class="form-control" name="username" value="<?= isset($username)?$username :$user->korisnicko_ime?>" />
                                            <?php if(isset($error['username'])): ?>
                                                <p class="errorText"><?= $error['username'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label>Profilna slika</label>
                                            <input type="file" name="picture" value="<?= $user->profilna_slika ?>"  class="form-control pb-4"/>
                                        </div>
                                    </div>
                                    <div class="mt-5 text-right">
                                        <input type="submit" class="btn btn-primary profile-button" name="edit-btn" value="Sacuvaj izmene"/>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>      
<?php
    include "templates/footer.php";
?>                 