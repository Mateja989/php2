<?php
    include "templates/head.php";
    include "templates/navigation.php";
    $x='agent';
    $agents=getAgentRequest(1);
    $agentsCount=getNumber($x);
?>  
        <main>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 mt-5">
                        <ul class="d-flex stay">
                            <li>Početna</li>
                            <span><li>/</li></span>
                            <li>Agenti</li>
                        </ul>
                    </div>
                    <h1>Agenti</h1>
                </div>
            </div>
            <hr class="line"/>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="text-properties1">
                            <p>Trenutno je aktivno  <span><?php echo $agentsCount ?></span> agent profila</p>
                        </div>
                        <div class="search2">
                            
                        </div>
                    </div>
                    <div class="row">
                        <?php if(isset($agents)): ?>
                            <?php foreach($agents as $agent): ?>
                                <div class="col-lg-3">
                                    <div class="text-center card-box">
                                        <div class="member-card pt-2 ">
                                        <div class="thumb-lg member-thumb mx-auto"><img src="<?= isset($agent->profilna_slika)?$agent->profilna_slika: 'assets/img/slika222.jpg' ?>" class="rounded-circle img-thumbnail" alt="profile-image"></div>
                                        <div class="pt-3 head">
                                            <h4 class="naslov"><?= $agent->ime. " " .$agent->prezime?></h4>
                                            <p class="text-muted">Agent</p>
                                        </div>
                                        <div class="">
                                            <p class="mail"><?= $agent->mail_adresa ?></p>
                                            <p class="licence">Broj dozvole</p>
                                            <p class="licence-value"><?= $agent->broj_dozvole ?></p>
                                        </div>
                                    </div>
                                </div>
                                </div>  
                            <?php endforeach; ?>
                        <?php endif; ?>
                            </div>  
                        </div>
                    </div>
                </div> 
            </div>  
        </main>
<?php
    include "templates/footer.php";
?>