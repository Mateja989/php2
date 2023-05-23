<?php
    include "templates/head.php";
    require_once "../templates/functions.php";
    $approved=1;
    $agentRe=getAgentRequest($approved);
?>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Spisak svih registrovanih korisnika</h2>
                    </div>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr class="red">
                                                <th >Ime i prezime</th>
                                                <th>Agent Id</th>
                                                <th>Email</th>
                                                <th class="text-right">Datum pristupanja</th>
                                                <th class="text-right">Broj dozvole</th>
                                                <th class="text-center">Obrisi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="agent">
                                    <?php if(count($agentRe)): ?>
                                        <?php foreach($agentRe as $agent): ?>
                                            <tr class="red">
                                                <td><?= $agent->ime. " " .$agent->prezime ?></td>
                                                <td><?= $agent->id_agent ?></td>
                                                <td><?= $agent->mail_adresa ?></td>
                                                <td class="text-right"><?= $agent->datum_kreiranja_profila ?></td>
                                                <td class="text-right"><?= $agent->broj_dozvole ?></td>
                                                <td class="text-center"><a class="btn-obrisi agentDelete" href="#"
                                                data-idagent="<?= $agent->id_agent?>"><i class="fa fa-trash"></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                            <h4 class="text-center">Trenutno nema zahteva</h4>
                                    <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>               
<?php
    include "templates/footer.php";
?>       