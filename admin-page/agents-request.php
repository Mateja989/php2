<?php
    include "templates/head.php";
    $agentRequest=getAgentRequest(0);

?>  
                    <!-- Content Row -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Spisak svih registrovanih korisnika</h2>
                    </div>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr class="red">
                                                <th >Ime i prezime</th>
                                                <th>Broj dozvole</th>
                                                <th>Email</th>
                                                <th class="text-right">Datum kreiranja zahteva</th>
                                                <th class="text-center">Odobri</th>
                                                <th class="text-center">Ukloni zahtev</th>
                                            </tr>
                                        </thead>
                                        <tbody id="requestAgent">
                                        <?php if(count($agentRequest)): ?>
                                            <?php foreach($agentRequest as $agent ): ?>
                                                <tr class="red">
                                                    <td><?= $agent->ime. " " .$agent->prezime ?></td>
                                                    <td><?= $agent->broj_dozvole ?></td>
                                                    <td><?= $agent->mail_adresa ?></td>
                                                    <td class="text-right"><?= $agent->datum_zahteva ?></td>
                                                    <td class="text-center"><a class="btn-potvrdiNek agentApprove" href="#" data-idapprove="<?= $agent->id_agent ?>"><i class="fa fa-check-circle"></i></a></td>
                                                    <td class="text-center"><a class="btn-obrisi agentRequestDelete" href="#" data-agentreqdelete="<?= $agent->id_agent ?>"><i class="fa fa-trash"></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <h4 class="text-center">Trenutno nema zahteva</h4>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div id="message">
                                    </div>
                                </div>               
<?php
    include "templates/footer.php";
?>              