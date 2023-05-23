<?php
    require_once "templates/functions.php";
    require_once "config/connection.php";
    include "templates/head.php";

   if(isset($_POST['btn-log'])){

      $username=$_POST["username"];
      $password=$_POST["password"];
      $error=[];

      $passwordReg="/^[A-Z]{1}[a-z0-9!@#$%^.&*]{7,19}$/";
      $usernameReg="/^([a-z]{1})[a-z0-9]{4,29}$/";

      $passwordCript=md5($_POST["password"]);

      if(!emptyInputLog($username,$password)){
         $error['emptyInput']="Sva polja su obavezna i moraju biti popunjena.";
      }
  
        //spakovati u funkciju sve se ponavlja
      if(!invalidInput($username,$usernameReg)){
         $error['username']="Korisnicko ime moze sadrzati samo mala slova i brojeve.";
      }

      if(!invalidInput($password,$passwordReg)){
         $error['password']="Lozinka mora zapoceti velikim slovom i imati 8 karaktera.";
      }


      if(count($error)==0){
         $user=loginUser($username,$passwordCript);
         if($user){
             $_SESSION['user']=$user;
             $userAgent=userAgent($username);
             if($userAgent){
                 $_SESSION['agent']=$userAgent;
             }
             header("location: profile.php");
         }
         else{
            $error['noUser']="Korisnicki nalog ne postoji.";
         }
      }
  }

?>
   <main>
        <div class="container mt-5">
                <div class="row">
                   <div class="col-lg-4 col-md-10 mx-auto mt-5 register-div">
                      <form method="POST" id="login-form" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="field">
                                <label for="">Korisničko ime</label>
                                <input type="text" class="form-control" id="username-login" value="<?= isset($username)?$username : ''?>"  name="username"/>
                                <p class="error hidden">Korisničko ime nije u dobrom formatu,upisati samo mala slova i najmanje 5 karaktera</p>
                                <?php if(isset($error['username'])): ?>
                                        <p class="error"><?= $error['username'] ?></p>
                                <?php endif; ?>
                                </div>
                               <div class="field">
                                <label for="">Lozinka</label>
                                <input type="password" class="form-control" id="password-login" value="<?= isset($password)?$password : ''?>"  name="password"/>
                               <p class="error hidden">Lozinka mora početi prvim velikim slovom i mora sadrzati bar 8 karakter</p>
                               <?php if(isset($error['password'])): ?>
                                        <p class="error"><?= $error['password'] ?></p>
                                 <?php endif; ?>
                               </div>
                               <div class="field mt-1">
                                <input type="submit" value="Prijava" class="btn btn-primary" id="btn-log" name="btn-log"/>
                                <?php if(isset($error['noUser'])): ?>
                                        <p class="error"><?= $error['noUser'] ?></p>
                                <?php endif; ?>
                                <p class="error text-center hidden">Ime nije uneto u dobrom formatu</p>
                               </div>
                      </form>
                   </div>
                </div>
             </div>
        </main>
       <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
