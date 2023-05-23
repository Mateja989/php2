<?php
    require_once "templates/head.php";
    require_once "templates/functions.php";

    if(isset($_POST['btn-reg'])){
      
        require_once "config/connection.php";
        require_once "templates/functions.php";
         
        $name=$_POST["first-name"];
        $surname=$_POST["last-name"];
        $username=$_POST["username"];
        $email=$_POST["mail"];
        $password=$_POST["password"];
        $repeatPass=$_POST["repeat-password"];
        $vkey=md5(time().$name);
        $passwordCript=md5($_POST["password"]);
        $error=[];
        

        $nameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/";
        $surnameReg="/^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/";
        $passwordReg="/^[A-Z]{1}[a-z0-9!@#$%^.&*]{7,19}$/";
        $usernameReg="/^([a-z]{1})[a-z0-9]{4,29}$/";
      
        if(!emptyInput($name,$surname,$username,$email,$password)){
          $error['emptyInput']="Sva polja su obavezna i moraju biti popunjena.";
        }
        if(!invalidInput($name,$nameReg)){
            $error['firstName']="Ime nije u dobrom formatu mora poceti velikim slovom.";
        }
        if(!invalidInput($surname,$surnameReg)){
            $error['lastName']="Prezime nije u dobrom formatu mora poceti velikim slovom.";
        }
        if(!invalidInput($password,$passwordReg)){
            $error['password']="Lozinka mora zapoceti velikim slovom i imati 8 karaktera.";
        }
        if(!invalidEmail($email)){
            $error['email']="Mejl nije u dobrom formatu.";
        }
        if(!invalidInput($username,$usernameReg)){
            $error['username']="Korisnicko ime moze sadrzati samo mala slova i brojeve i najmanje 5 karaktera.";
        }
        if($repeatPass!=$password){
            $error['repeatPasswd']="Potvrda lozinke se ne poklapa sa lozinkom.";
        }
        if(!existEmail($email)){
            $error['existMail']="Mejl adresa vec postoji u bazi.";
        }
        if(!existUsername($username)){
            $error['existUser']="Korisnicko ime vec postoji u bazi.";
        }

        
        if(count($error)==0){
            $result=registrationUser($name,$surname,$username,$email,$passwordCript,$vkey);
            if(!$result){
              $error['serverError']="Greska prilikom upisa u bazu";
            }
            else{
                $to=$email;
                $subject="Verifikacija naloga";
                $body="Aktivirajte svoj nalog,klikom na sledeci<a href='http://localhost/HomeID/models/verify.php?vkey=$vkey'>link</a>";
                $sender="From:homeaplikacija@gmail.com \r\n";
                $sender.="MIME-Version: 1.0" . "\r\n";
                $sender.="Content-type:text/html;charset-UTF-8" . "\r\n";
                mail($to, $subject, $body,$sender);
                $success['uspeh']="Uspesno ste se registrovali proverite mejl za verifikaciju.";
            }
        }
    }
      

?>
  <main>
        <div class="container">
                <div class="row">
                   <div class="col-lg-4 col-md-10 mx-auto mt-2 register-div">
                      <form method="POST" id="registration-form" action="<?=$_SERVER['PHP_SELF']?>">
                            <?php if(isset($success['uspeh'])): ?>
                                    <p class="success"><?= $success['uspeh'] ?></p>
                                    <button class="btn"><a href='log.php'>Uloguj se</a></button>
                               <?php endif; ?>
                                <div class="field">
                                    <label for="name">Ime</label>
                                    <input type="text" class="form-control" value="<?= isset($name)?$name : ''?>"
                                    id="first-name" name="first-name"/>
                                    <p class="error hidden"> Ime nije uneto u dobrom formatu </p>
                                    <?php if(isset($error['firstName'])): ?>
                                        <p class="error"><?= $error['firstName'] ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <label for="">Prezime</label>
                                    <input type="text" class="form-control" value="<?= isset($surname)?$surname : ''?>" name="last-name" id="last-name"/>
                                   <p class="error hidden">Prezime nije uneto u dobrom formatu</p>
                                    <?php if(isset($error['lastName'])): ?>
                                        <p class="error"><?= $error['lastName'] ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <label for="">Korisničko ime</label>
                                <input type="text" class="form-control" id="username" value="<?= isset($username)?$username : ''?>" name="username"/>
                               <p class="error hidden">Korisničko ime nije u dobrom formatu,upisati samo mala slova i najmanje 5 karaktera</p>
                                <?php if(isset($error['username'])): ?>
                                        <p class="error"><?= $error['username'] ?></p>
                                <?php elseif(isset($error['existUser'])): ?>
                                    <p class="error"><?= $error['existUser'] ?></p>
                                <?php endif; ?>
                                </div>
                                <div class="field">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" value="<?= isset($email)?$email : ''?>" id="mail"  name="mail"/>
                                <p class="error hidden">Email nije  u dobrom formatu</p>
                                <?php if(isset($error['email'])): ?>
                                        <p class="error"><?= $error['email'] ?></p>
                                <?php elseif(isset($error['existMail'])): ?>
                                    <p class="error"><?= $error['existMail'] ?></p>
                                <?php endif; ?>
                                </div>
                               <div class="field">
                                <label for="">Lozinka</label>
                                <input type="password" class="form-control" value="<?= isset($password)?$password : ''?>" id="password" name="password"/>
                                <p class="error hidden">Lozinka mora početi prvim velikim slovom i mora sadrzati bar 8 karakter</p>
                                <?php if(isset($error['password'])): ?>
                                        <p class="error"><?= $error['password'] ?></p>
                                    <?php endif; ?>
                               </div>
                               <div class="field">
                                <label for="">Potvrda lozinke</label>
                                <input type="password" class="form-control"id="repeat-password" name="repeat-password"/>
                               <p class="error hidden">Potvrda lozinke se ne poklapa sa unetom lozinkom</p>
                               <?php if(isset($error['repeatPasswd'])): ?>
                                        <p class="error"><?= $error['repeatPasswd'] ?></p>
                                    <?php endif; ?>
                               <div class="field mt-1">
                                <input type="submit" value="Prijava" class="btn btn-primary" id="btn-reg" name="btn-reg"/>
                               </div>
                               <?php if(isset($error['emptyInput'])): ?>
                                    <p class="error"><?= $error['emptyInput'] ?></p>
                               <?php endif; ?>
                      </form>
                   </div>
                </div>
             </div>
        </main>
       <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>

