<?php  
    include "templates/head.php";
    include "templates/navigation.php";
    if(isset($_SESSION['user'])){
      $idUser=$_SESSION['user']->id_korisnik;
      $scheduleInfo=getInfoSchedule($idUser);
    }
    $user=getUser($idUser);
    if(isset($_SESSION['agent'])){
      $id=$_SESSION['agent']->id_agent;
      $userProperties=getUserProperties($id);
      $scheduledTime=getscheduledTime($id);
    }

?>
    <?php if(isset($_SESSION['user']) && $_SESSION['user']->id_uloga==2): ?>
      <main>
      <div class="modal-bg">
        <div class="nes col-4">
				  <h3 class="text-center">Da li ste sigurni da želite da obrišete nalog?</h3>
				  <p>Brisanjem naloga obrisaće se sve sto postoji i vezano je za Vaš profil,kao sto su zakazazani termini,oglasi i poruke.</p>
				  <a class="btn-obrisiNek" href="#" id="deleteProfile" data-iddelete="<?= $user->id_korisnik?>">Ipak obrisi</a>
				  <a class="btn-izmeniNek" href="#" id="closeModal">Odustani</a>
			  </div>
		  </div>
            <div class="container">
                <div class="main-body mm-margina">
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                          <div class="card">
                            <div class="card-body">
                              <div class="d-flex flex-column align-items-center text-center">
                                <?php if(isset($user->profilna_slika)): ?>
                                <img src="<?= $user->profilna_slika ?>" alt="Admin" class="rounded-circle" width="150">
                                <?php else: ?>
                                <img src="assets/img/slika222.jpg" alt="Admin" class="rounded-circle" width="150">
                                <?php endif; ?>
                                <div class="mt-3">
                                  <h4><?= $user->ime. " " .$user->prezime ?></h4>
                                  <p class="text-secondary mb-1"><?= $user->mail_adresa ?></p>
                                  <a href="update-profile.php?id=<?= $user->id_korisnik?>"><button class="btn-izmeni">Izmeni profil</button></a>
                                  <a href="#" id="deleteMessage"><button class="btn-obrisi">Obriši profil</button></a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Id</h6>
                                <span class="text-secondary"><?= $user->id_korisnik ?></span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Uloga</h6>
                                <span class="text-secondary"><?= $user->naziv_uloga ?></span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Korisnicko ime</h6>
                                <span class="text-secondary"><?= $user->korisnicko_ime ?></span>
                              </li>
                            <?php if(isset($_SESSION['agent'])): ?>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Agent status</h6>
                                <span class="text-secondary">Aktivan</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-center align-items-center flex-wrap">
                                <a href="properties-insert.php"><button class="btn-agent">Postavi novi oglas</button></a>
                              </li>
                            <?php else: ?>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Agent status</h6>
                                <span class="text-secondary">N/A</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-center align-items-center flex-wrap">
                                <a href="agent-register.php"><button class="btn-agent">Unapredi agent status</button></a>
                              </li>
                            <?php endif; ?>
                            </ul>
                          </div>
                        </div>
                        <?php if(isset($_SESSION['agent'])): ?>
                        <div class="col-md-8">
                            <div class="row">
                                <h2 class="mb-3">Postavljeni oglasi</h2>
                                <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr class="red">
                                        <th >Naziv oglasa</th>
                                        <th>Datum postavljanja</th>
                                        <th class="text-right">Pregled</th>
                                        <th class="text-right">Obriši</th>
                                    </tr>
                                </thead>
                                <tbody id="tableProfile">
                                    <?php foreach($userProperties as $prop ): ?>
                                      <tr class="red">
                                        <td><?= $prop->naziv ?></td>
                                        <td><?= $prop->datum_postavljanja ?></td>
                                        <td class="text-center"><a class="btn-potvrdiNek" href="/propertie-page.php?idProp=<?= $prop->id_nekretnine ?>" id="realEstate" data-id="<?= $prop->id_nekretnine ?>"><i class="fa fa-eye"></i></a></td>
                                        <td class="text-center"><a class="btn-obrisiNek deleteAdUser" href="#"  data-iddeletead="<?= $prop->id_nekretnine ?>"
                                        ><i class="fa fa-trash"></a></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                                </div> 
                                <h2 class="mb-3">Zakazani termini razgledanja</h2>
                                <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr class="red">
                                        <th>Naziv</th>
                                        <th>Datum</th>
                                        <th>Termin(H)</th>
                                        <th>Korisnik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if(count($scheduledTime)): ?>
                                    <?php foreach($scheduledTime as $x ): ?>
                                      <tr class="red">
                                        <td><?= $x->naziv ?></td>
                                        <td><?= $x->datum_zakazivanja ?></td>
                                        <td><?= $x->termin ?></td>
                                        <td><?= $x->ime. " " .$x->prezime ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                  <?php else: ?>
                                    <p>Trenutno ne postoje zakazani termini</p>
                                  <?php endif; ?>
                                </tbody>
                            </table>
                                </div>                          
                            </div>
                        </div>
                        <?php else: ?>
                          <div class="col-md-8">
                            <div class="row">
                                <h2 class="mb-3">Zakazani termini obilaska</h2> 
                                <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr class="red">
                                                <th>Nekretnina</th>
                                                <th>Datum</th>
                                                <th>Termin(H)</th>
                                                <th class="text-right">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php if(count($scheduleInfo)):  ?>
                                            <?php foreach($scheduleInfo as $x): ?>
                                                <tr class="red">
                                                    <td class="text-right"><?= $x->naziv ?></td>
                                                    <td class="text-right"><?= $x->datum_zakazivanja ?></td>
                                                    <td class="text-right"><?= $x->termin ?></td>
                                                    <td>Zakazano</td>
                                                </tr>
                                            <?php endforeach; ?>
                                          <?php else: ?>
                                            <p>Trenutno nema zakaznih termina</p>
                                          <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
        </main>
    <?php else: ?>
        <?= header('Location: index.php') ?>
    <?php endif; ?>
<?php
    include "templates/footer.php";
?>
