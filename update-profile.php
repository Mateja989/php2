<?php  
    include "templates/head.php";
    include "templates/navigation.php";
    $idUser=$_SESSION['user']->id_korisnik;
    $user=getUser($idUser);


    if(isset($_SESSION['agent'])){
      $idAgent=$_SESSION['agent']->id_agent;
      $agentInfo=getAgent($idAgent);
    }

    if(isset($_POST['updateAgent'])){
      $phone=$_POST['phone'];
      $phoneReg="/^06[\d]{7,8}$/";
      $error=[];
      

      if(!invalidInput($phone,$phoneReg)){
        $error['phone']="Telefon nije u dobrom formatu,mora poceti sa 06*** i moze sadrzati 7 cifara.";
      }

      if(count($error)==0){
        $updateAgent=agentUpdate($idAgent,$phone);
        if($updateAgent){
          $success['uspeh']="Uspesno ste uradili izmene.";
        }
        
      }
    }

    if(isset($_POST['btn-update'])){

      $name=$_POST['firstName'];
      $lastName=$_POST['lastName'];
      $username=$_POST['username'];
      $mail=$_POST['email'];
      $id=$_SESSION['user']->id_korisnik;

      $error=[];

      $nameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/";
      $surnameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/";
      $usernameReg="/^([a-z]{1})[a-z0-9]{4,29}$/";

      if(!emptyInputForUpdate($name,$lastName,$username,$mail)){
        $error['emptyInput']="Sva polja su obavezna i moraju biti popunjena.";
      }

      if(!invalidInput($name,$nameReg)){
        $error['firstName']="Ime nije u dobrom formatu mora poceti velikim slovom.";
      }
      if(!invalidInput($lastName,$surnameReg)){
        $error['lastName']="Prezime nije u dobrom formatu mora poceti velikim slovom.";
      }
      if(!invalidInput($username,$usernameReg)){
        $error['username']="Korisnicko ime moze sadrzati samo mala slova i brojeve i najmanje 5 karaktera.";
      }
      if(!invalidEmail($mail)){
        $error['email']="Mejl nije u dobrom formatu.";
      }

      if(count($error) == 0){
        $updateProfile=updateProfile($name,$lastName,$mail,$username,$id);
        if($updateProfile){
            $success['success']="Uspesno ste izmenili informacije profila";
        }else{
            $error['errorUpdate']="Doslo je do greske prilikom izmene profila";
        }
      }

  }
?>
<?php if(isset($_SESSION['user'])): ?>
    <main>
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <?php if(isset($user->profilna_slika)): ?>
                      <img class="rounded-circle mt-5" width="150px" src="<?= $user->profilna_slika  ?>">
                    <?php else: ?>
                      <img class="rounded-circle mt-5" width="150px" src="assets/img/slika222.jpg">
                    <?php endif; ?>
                      <span class="font-weight-bold"><?= $user->korisnicko_ime ?></span>
                      <span class="text-black-50"><?= $user->mail_adresa ?></span>
                      <span>
                      <?php if(!isset($user->profilna_slika)): ?>
                      <form action='models/upload.php' method='post' enctype='multipart/form-data' name='uploadpic'>
                          <input type="hidden" name="user" id="user" value="<?= $user->id_korisnik ?>" />
                          <input type="file" name="userpicture" id="userpicture" />
                          <input type="submit" class="btn" name="upload" value="Postavi fotografiju profila" id='upload' />
                        </form>
                      <?php endif; ?>
                      </span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Podaci o profilu</h4>
                        </div>
                        <div class="row mt-3">
                          <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="update-profile-form" enctype='multipart/form-data'>
                            <div class="col-md-12">
                              <label class="labels">Ime</label>
                              <input type="text" class="form-control" value="<?= isset($name)?$name :$user->ime?>" name="firstName" id="update-first-name">
                              <?php if(isset($error['firstName'])): ?>
                                <p class="error"><?= $error['firstName'] ?></p>
                              <?php endif; ?>
                              <p class="error mm-b hidden">Ime nije u dobrom formatu</p>
                            </div>
                            <div class="col-md-12">
                              <label class="labels">Prezime</label>
                              <input type="text" class="form-control" value="<?= isset($lastName)?$lastName :$user->prezime?>"  name="lastName" id="update-last-name">
                              <?php if(isset($error['lastName'])): ?>
                                        <p class="error"><?= $error['lastName'] ?></p>
                              <?php endif; ?>
                              <p class="error mm-b hidden">Prezime nije u dobrom formatu</p>
                            </div>
                            <div class="col-md-12">
                              <label class="labels">Korisnicko ime</label>
                              <input type="text" class="form-control" value="<?= isset($username)?$username :$user->korisnicko_ime?>"  name="username" id="update-username">
                              <?php if(isset($error['username'])): ?>
                                        <p class="error"><?= $error['username'] ?></p>
                              <?php endif; ?>
                             <p class="error mm-b hidden">Korisnicko ime nije u dobrom formatu najmanje 5 karaktera</p>
                            </div>
                            <div class="col-md-12">
                              <label class="labels">Email adresa</label>
                              <input type="text" class="form-control"  value="<?= isset($mail)?$mail :$user->mail_adresa?>" name="email" id="update-mail">
                              <?php if(isset($error['email'])): ?>
                                  <p class="error"><?= $error['email'] ?></p>
                              <?php endif; ?>
                              <p class="error mm-5 hidden">Email adresa nije u dobrom formatu</p>
                            </div>
                        </div>
                        <div class="text-center">
                          <input type="submit" class="btn-izmeniA" id="btn-update" name="btn-update" value="Potvrdi izmene">
                          <?php if(isset($success['success'])): ?>
                                  <p class="success"><?= $success['success'] ?></p>
                          <?php endif; ?>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php else: ?>
        <?= header('Location: index.php') ?>
<?php endif; ?>
<?php
    unset($_SESSION['success']);
    unset($_SESSION['success']);
    include "templates/footer.php";
?>

