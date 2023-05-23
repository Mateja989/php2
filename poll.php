<?php  
    include "templates/head.php";
    include "templates/navigation.php";
    require_once "config/connection.php";
    require_once "templates/functions.php";
    if(isset($_SESSION['user'])){
      $idUser=$_SESSION['user']->id_korisnik;
    }
    $poll=getPullQuestionAndAnswer();
    function vratiOdgovore($niz, $idPitanje) {
      $s = "";
      foreach($niz as $el) {
          if ($el->id_pitanje == $idPitanje)
              $s .="<div><input type='radio' name='question$el->id_pitanje' value='$el->id_apo' class='answer'/><label for='answer'>$el->tekst_odgovor</label></div>";
      }
      return $s;
    }
    
?>
<?php if(isset($_SESSION['user']) && $_SESSION['user']->id_uloga==2): ?>
      <main>
      <div class="container mt-5">
                <div class="row">
                    <div class="col-12 mt-5">
                        <ul class="d-flex stay">
                            <li>Početna</li>
                            <span><li>/</li></span>
                            <li>Anketa</li>
                        </ul>
                    </div>
                    <h1>Anketa</h1>
                </div>
            </div>
            <hr class="line"/>
            <form action="models/poll.php" method="post">
            <div class="container">
                <div class="main-body">
                    <div class="row gutters-sm">
                          <div class="mb-5 mt-3">
                            <div class="card-body">
                              <div class="d-flex poll">
                              <?php $pitanjeID = -1; ?>
                              <?php foreach($poll as $el): ?>
                                  <?php if($pitanjeID!=$el->id_pitanje): ?>
                                    <div class="pollAnswer col-lg-6 col-md-12">
                                    <h4><?= $el->tekst_pitanja ?></h4>
                                    <?php $pitanjeID=$el->id_pitanje; ?>
                                    <?php echo (vratiOdgovore($poll, $pitanjeID)); ?>
                                    </div>
                                    <?php else: continue; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </div>
                                <div class="ddl custom-select mb-3 mt-3">
                                    <input type="submit" class="btn" name="btn-poll" value="Glasaj"/>
                                    <?php if(isset($_SESSION['error'])): ?>
                                      <p class="error"><?= $_SESSION['error'] ?></p>
                                    <?php unset($_SESSION['error']); ?>
                                    <?php endif; ?>
                                    <?php if(isset($_SESSION['success'])): ?>
                                      <p class="success"><?= $_SESSION['success'] ?></p>
                                    <?php unset($_SESSION['success']); ?>
                                    <?php endif; ?>
                                    <?php if(isset($_SESSION['exist'])): ?>
                                      <p class="error"><?= $_SESSION['exist'] ?></p>
                                    <?php unset($_SESSION['exist']); ?>
                                    <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </form>
            </div> 
        </main>
    <?php else: ?>
        <?= header('Location: index.php') ?>
    <?php endif; ?>
<?php
    include "templates/footer.php";
?>