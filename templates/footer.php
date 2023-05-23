<?php
    if(isset($_POST['send'])){
        $email=$_POST['email'];
        $error=[];
        if(!invalidEmail($email)){
            $error['email']="Mejl nije u dobrom formatu.";
        }
        if(count($error)==0){
            $result=newslatterInsert($email);
            if($result){
              $success['send']='Upesno ste je prijavili na nasu newslatter listu.';
            }
        }
    }
?>
<footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-sm-12 slika">
                        <img src="assets/img/logo-white.png" alt="">
                        <ul class="futer">
                            <li>Knez Mihailova 10,Beograd</li>
                            <li>contact@homeid.com</li>
                            <li>(+381) 61 122 9876</li>
                            <li>www.homeid.com</li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-12 headerFuter">
                        <h4>Brzi Linkovi</h4>
                        <ul class="futer">
                            <li><a href="index.php">Početna</a></li>
                            <li><a href="dokumentacija php.pdf">Dokumentacija</a></li>
                            <li><a href="https://mateja989.github.io/matejamastelicaportfolio.github.io/">Autor</a></li>
                        </ul>
                    </div>
                <div class="col-lg-4 col-md-8 col-sm-12 headerFuter">
                    <h4 class="mb-3">Prijavite se na naš newslatter</h4>
                            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="text-center mb-5 mt-5" id="formaNewslatter">
                                <input type="text" id="email" name="email" value="<?= isset($email)?$email : ''?>" placeholder="Upišite svoju mejl adresu...">
                                <p class="error hidden">Mejl adresa nije u dobrom formatu</p>
                                <input type="submit" id="send" name="send"  value="Pošalji"/>
                                <?php if(isset($error['email'])): ?>
                                    <p class="error"><?= $error['email'] ?></p>
                                <?php elseif(isset($success['send'])): ?>
                                    <p class="success"><?= $success['send'] ?></p>
                            <?php endif; ?>
                    </form>
                </div>
                </div>
            </div>
            <hr class="line"/>
            <p class="cp text-center">©Mateja Mastelica 73/20.Sva prava zadržana</p>
        </footer>
        <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>