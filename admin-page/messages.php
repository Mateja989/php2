<?php
    include "templates/head.php";
    $messages=getAll('kontakt');

?>  
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Poruke</h2>
                    </div>
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr class="red">
                                    <th >Ime i prezime</th>
                                    <th>Naslov</th>
                                    <th>Status</th>
                                    <th class="text-center">Oznaka</th>
                                    <th class="text-center">Obrisi</th>
                                </tr>
                            </thead>
                            <tbody id="mesagesTable">
                                <?php if(count($messages)): ?>
                                    <?php foreach($messages as $x): ?>
                                        <tr class="red">
                                            <td><?= $x->ime. " " .$x->prezime?></td>
                                            <td><?= $x->naslov?></td>
                                            <?php if($x->procitano): ?>
                                                <td>Procitana</td>
                                                <td class="text-center"><a class="btn-potvrdiNek" href="/admin-page/message-page.php?id=<?= $x->id_poruke ?>"><i class="fa fa-check-circle"></i></a></td>
                                            <?php else: ?>
                                                <td>Neprocitana</td>
                                                <td class="text-center"><a class="btn-potvrdiNek3" href="/admin-page/message-page.php?id=<?= $x->id_poruke ?>"><i class="fa fa-eye"></i></a></td>
                                            <?php endif; ?>
                                            <td class="text-center"><a class="btn-obrisiNek deleteMessage" href="#" data-message="<?= $x->id_poruke ?>"><i class="fa fa-trash"></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <h4 class="text-center">Trenutno nema poruka korisnika sajta.</h4>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>  
<?php
    include "templates/footer.php";
?>  