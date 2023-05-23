<?php
    include "templates/head.php";
    include "templates/navigation.php";
    if(isset($_SESSION['user'])){
      $idUser=$_SESSION['user']->id_korisnik;
      $uloga=$_SESSION['user']->id_uloga;
    }
    $id=$_GET['idProp'];
    $propertieInfo=getFullInfoProp($id);
    $activeInfo=infoActive($id);
    $specifications=getFullSpecification($id);
    $schedule=getSchedule();
    $propertiesPicture=getPictures($id);
    $getAllPropertiesId=getIds();
    $arrayId=[];
    foreach($getAllPropertiesId as $x){
      $arrayId[]= $x->id_nekretnine;
    }    

    if(isset($_POST['scheduleBtn'])){

      $date=$_POST['dateSchedule'];
      $userId=$_POST['user'];
      $agent=$_POST['agent'];
      $propertie=$_POST['propertie'];
      $scheduleId=$_POST['schedule-ddl'];
      $error=[];

     // $neki=existAppointmentForAgent($scheduleId,$date,$agent);
      

     // if(existAppointmentForAgent($scheduleId,$date,$agent)){
      //  $error['existAppointment']="Agent je zauzet u ovom terminu.";
     // }



     // if(count($error)){
        $insertAppointment=insertAppointment($date,$userId,$agent,$propertie,$scheduleId);
        if($insertAppointment){
          header('location: profile.php');
      //  }
      //  else{
      //    $error['error']="Zakazivanje nije uspelo.";
        }
      //}

    }

    
?>
<?php if(isset($_GET['idProp']) && in_array($id,$arrayId)): ?>
<main>
    <div class="container mt-5-mm">
  <div id="carouselExampleIndicators" class="carousel" data-ride="carousel">
  
  </div>
    </div>
    <div class="container bor">
        <div class="row justify-content-between nesto">
            <div class="main-properties">
                <div class="descriptionDiv">
                    <div class="one">
                        <?php if($propertieInfo->naziv_strukture=="Izdavanje"): ?>
                          <div class="izdavanje"><p>Za izdavanje</p></div>
                        <?php else: ?>
                          <div class="prodaja"><p>Za prodaju</p></div>
                        <?php endif; ?>
                        <p><?="Objavljen". " " .$propertieInfo->datum_postavljanja ?></p>
                    </div>
                    <div class="naslovNekretnine">
                        <h2><?= $propertieInfo->naziv ?></h2>
                        <p><?= $propertieInfo->cena.",00 EUR" ?></p>
                    </div>
                    <div class="nekretnineGrad2">
                        <h4><?= $propertieInfo->naziv_grad ?></h4>
                    </div>
                    <div class="nekretnineOpisi">
                        <h3>Opis</h3>
                        <p><?= $propertieInfo->opis ?></p>
                    </div>
                    <h3 class="infoNaslov">Dodatne informacije</h3>
                    <div class="nekretnineDodatneInfo">
                        <table class="tabela1">
                            <tbody>
                                <tr>
                                    <td class="imeSvojstvo">Id nekretnine</td>
                                    <td class="vrednost"><?= $propertieInfo->id_nekretnine ?></td>
                                </tr>
                                <tr>
                                    <td class="imeSvojstvo">Datum postavljanja</td>
                                    <td class="vrednost"><?= $propertieInfo->datum_postavljanja ?></td>
                                </tr>
                                <tr>
                                    <td class="imeSvojstvo">Tip</td>
                                    <td class="vrednost"><?= $propertieInfo->naziv_tip ?></td>
                                </tr>
                                <tr>
                                    <td class="imeSvojstvo">Transakcija</td>
                                    <td class="vrednost"><?= $propertieInfo->naziv_strukture ?></td>
                                </tr>
                                <tr>
                                    <td class="imeSvojstvo">Agent</td>
                                    <td class="vrednost"><?= $propertieInfo->ime. " " .$propertieInfo->prezime?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="tabela2">
                            <tbody>
                              <?php foreach($specifications as $spec): ?>
                                <tr>
                                    <td class="imeSvojstvo"><?= $spec->naziv_specifikacija ?></td>
                                    <?php if(($spec->naziv_specifikacija) == 'Kvadratura'): ?>
                                    <td class="vrednost"><?= $spec->vrednost. " m²" ?></td>
                                    <?php else: ?>
                                      <td class="vrednost"><?= $spec->vrednost ?></td>
                                    <?php endif; ?>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="sidebar">
            <div clas="">
            <div class="text-center card-box">
                  <div class="member-card pt-2 ">
                  <div class="thumb-lg member-thumb mx-auto"><img src="<?= $propertieInfo->profilna_slika ?>" class="rounded-circle img-thumbnail" alt="profile-image"></div>
                  <div class="pt-3 head">
                      <h4 class="naslov"><?= $propertieInfo->ime. " " .$propertieInfo->prezime?></h4>
                      <p class="text-muted">Agent</p>
                  </div>
                  <div class="">
                      <p class="mail"><?= $propertieInfo->mail_adresa?></p>
                      <p class="licence">Broj dozvole</p>
                      <p class="licence-value"><?= $propertieInfo->broj_dozvole?></p>
                  </div>
                  <div class="listing">
                      <a href="">
                          <p class="">Agent</p>
                      </a>
                  </div>
              </div>
              </div>
              <?php if(!isset($_SESSION['agent'])): ?>
              <div class="search mt-5 mb-5">
              <?php if(isset($_SESSION['user']) && $_SESSION['user']->id_uloga==2): ?>
                  <h3>Zakazi pregledanje</h3>
                  <form method="POST" id="schedule-form" action="/propertie-page.php?idProp=<?=$propertieInfo->id_nekretnine?>">
                      <div class="ddl custom-select">
                        <label id="datum">Izaberite datum</label>
                        <input type="date" id="dateSchedule" class="zakaziTermin" name="dateSchedule">
                        <p class="error hidden" >Datum mora biti izabran i odgovarati buducim danima</p>
                        <input type="hidden" id="user" value="<?= $idUser ?>" name="user"/>
                        <input type="hidden" id="agent" value="<?= $propertieInfo->id_agent ?>" name="agent"/>
                        <input type="hidden" id="propertie" value="<?= $propertieInfo->id_nekretnine?>" name="propertie"/>
                      </div>   
                      <div class="ddl custom-select">
                          <select name="schedule-ddl" id="schedule-ddl">
                              <option value="">Termin</option>
                              <?php foreach($schedule as $x): ?>
                              <option value="<?= $x->id_termin ?>"><?= $x->termin?></option>
                              <?php endforeach; ?>
                          </select>
                          <p class="error hidden">Termin mora biti izabran</p>
                      </div>
                      <input type="submit" value="Zakazi" id="zakazibtn" name="scheduleBtn">
                      <?php if(isset($error['existAppointment'])): ?>
                                  <p class="error"><?= $error['existAppointment'] ?></p>
                      <?php endif; ?>
                      <?php if(isset($error['error'])): ?>
                                  <p class="error"><?= $error['error'] ?></p>
                      <?php endif; ?>
                  </form>
                  <?php elseif(isset($_SESSION['user']) && $_SESSION['user']->id_uloga==1): ?>
                    <h3>Odobravanje oglasa</h3>
                    <?php if($activeInfo->odobren): ?>
                      <p class="confirmAd text-center">Oglas je trenutno aktivan</p>
                    <?php else: ?>
                      <p class="confirmAd2 text-center" id="messageSuccess"><a href="#" class="ad-approve" data-adrequest="<?=$propertieInfo->id_nekretnine ?>">Odobri oglasavanje</a></p>
                    <?php endif; ?>
                  <?php else: ?>
                    <h3>Zakazi pregledanje</h3>
                  <p class='text-center reg-text'>Samo registrovani korisnici mogu da zakazuju termine razgledanja</p>
                <?php endif; ?>
              </div> 
            </div>
            <?php elseif(isset($_SESSION['agent']) && $propertieInfo->id_korisnik==$idUser): ?>
              <div class="search mt-5 mb-5">
                <h3>Postavi novu sliku</h3>
                <?php if(count($propertiesPicture) >= 3): ?>
                  <p>Vec ste dodali maksimalan broj slika u oglas</p>
                <?php else: ?>
                  <form method="POST" id="" action="models/upload-addphoto.php" enctype='multipart/form-data'>
                      <div class="ddl custom-select">
                        <input type="hidden" name="ad" id="ad" value="<?= $propertieInfo->id_nekretnine?>" />
                        <input type="file" name="adpicture" id="adpicture" />
                      </div>   
                      <input type="submit" value="Postavi novu sliku" id="zakazibtn" name="adpictureBtn">
                  </form>
                <?php endif; ?>
              </div> 
            </div>
            <?php endif; ?>
        </div>
    </div>  
</main>
<?php else: ?>
  <?php header('location: index.php'); ?>
<?php endif; ?>
<?php
    include "templates/footer.php";
?>


    
     