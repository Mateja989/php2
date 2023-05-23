<?php
    include "templates/head.php";
    $inactive=0;
    $requestAd=advertisementApprove($inactive);
?>  
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Zahtevi za odobravanje oglasa</h2>
                    </div>
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr class="red">
                                    <th >Id</th>
                                    <th>Naziv</th>
                                    <th>Agent</th>
                                    <th class="text-right">Datum pristupanja</th>
                                    <th class="text-center">Pregled</th>
                                    <th class="text-center">Brisanja</th>
                                </tr>
                            </thead>
                            <tbody id="adReq">
                                <?php if(count($requestAd)): ?>
                                    <?php foreach($requestAd as $x): ?>
                                    <tr class="red">
                                        <td><?= $x->id_nekretnine ?></td>
                                        <td><?= $x->naziv ?></td>
                                        <td><?= $x->ime. " " .$x->prezime ?></td>
                                        <td class="text-right"><?= $x->datum_postavljanja ?></td>
                                        <td class="text-center"><a class="btn-potvrdiNek" href="/propertie-page.php?idProp=<?= $x->id_nekretnine ?>"><i class="fa fa-eye"></i></a></td>
                                        <td class="text-center"><a class="btn-obrisiNek deleteReqAd" href="#" data-deleteadreq="<?= $x->id_nekretnine ?>"><i class="fa fa-trash"></a></td>
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