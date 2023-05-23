<?php
    include "templates/head.php";
    include "templates/navigation.php";
  

    if(isset($_POST['btn-contact'])){
      
      $firstName=$_POST['firstName'];
      $lastName=$_POST['lastName'];
      $headline=$_POST['headline'];
      $message=$_POST['message'];
      $error=[];

      $firstNameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/";
      $lastNameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/";
      $headlineReg="/^[\w\d\s!?*]{1,99}$/";

      echo $firstName;


      if(!invalidInput($firstName,$firstNameReg)){
        $error['firstName']="Ime nije u dobrom formatu mora poceti velikim slovom.";
      }
      if(!invalidInput($lastName,$lastNameReg)){
          $error['lastName']="Prezime nije u dobrom formatu mora poceti velikim slovom.";
      }
      if(!invalidInput($headline,$headlineReg)){
          $error['headline']="Naslov nije u dobrom formatu.";
      }
      if(count($error)==0){
        $sendMessage=sendMessage($firstName,$lastName,$headline,$message);
        if($sendMessage){
          $success['send']="Uspesno ste poslali poruku.";
        }
      }
      
    }
?>
 <main>
    <div class="container mt-5">
      <div class="row">
          <div class="col-12">
              <ul class="d-flex stay">
                  <li>Pocetna</li>
                  <span><li>/</li></span>
                  <li>Kontakt</li>
              </ul>
          </div>
          <h1>Kontakt</h1>
      </div>
      <hr class="line"/>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-lg-7 col-md-12">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="contactForm">
          <div class="kontaktForma">
            <input type="text" class="" placeholder="Ime" value="<?= isset($firstName)?$firstName : ''?>" id="firstName" name="firstName"/>
            <?php if(isset($error['firstName'])): ?>
              <p class="error"><?= $error['firstName'] ?></p>
            <?php endif; ?>
            <p class="error hidden">Ime nije u dobrom formatu</p>
          </div>
          <div class="kontaktForma">
            <input type="text" class="" placeholder="Prezime" value="<?= isset($lastName)?$lastName : ''?>"  id="lastName" name="lastName"/>
            <?php if(isset($error['lastName'])): ?>
              <p class="error"><?= $error['lastName'] ?></p>
            <?php endif; ?>
            <p class="error hidden">Prezime nije u dobrom formatu</p>
          </div>
          <div class="kontaktForma">
            <input type="text" class="" placeholder="Naslov" value="<?= isset($headline)?$headline : ''?>"  id="headline" name="headline"/>
            <?php if(isset($error['headline'])): ?>
              <p class="error"><?= $error['headline'] ?></p>
            <?php endif; ?>
            <p class="error hidden">Naslov nije u dobrom formatu</p>
          </div>
          <textarea type="text" rows="5"  class="mt-3 form-control kontaktPoljeZaTekst" placeholder="Describe yourself here..." value="<?= isset($message)?$message : ''?>"  id="message" name="message">
          </textarea>
          <p class="error hidden">Sadrzaj nije u dobrom formatu</p>
          <input type="submit" class="btn btnContact" id="btnCont" value="Pošaljite poruku" name="btn-contact"/>
          <?php if(isset($success['send'])): ?>
              <p class="success"><?= $success['send'] ?></p>
            <?php endif; ?>
        </form>
      </div>
      <div class="col-lg-5 col-md-12 mt-5">
        <h3 class="text-center">Podaci</h3>
        <p class="text-center pKontakt">HomeID D.O.O</p>
        <p class="text-center pKontakt">Bulevar Kralja Aleksandra 11,Beograd</p>
        <p class="text-center pKontakt">Srbija</p>
        <p class="text-center pKontakt">Mobile: +381 61 12 13 148</p>
        <p class="text-center pKontakt">Email: info@homeid.com</p>
      </div>
    </div>
  </div>
  </main>
<?php
    include "templates/footer.php";
?>



