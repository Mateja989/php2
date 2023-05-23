<?php
    include "templates/head.php";
    $active=1;
    $propertiesList=getFullList($active);
?>  
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Spisak svih aktivnih oglasa</h2>
                    </div>
                                <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr class="red">
                                                <th >Naziv</th>
                                                <th>Agent</th>
                                                <th class="text-right">Datum kreiranja</th>
                                                <th class="text-right">Pregled</th>
                                                <th class="text-center">Obrisi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="adFullList">
                                        <?php if(count($propertiesList)): ?>
                                        <?php foreach($propertiesList as $x): ?>
                                            <tr class="red">
                                                <td><?= $x->naziv ?></td>
                                                <td><?= $x->ime. " " .$x->prezime ?></td>
                                                <td class="text-right"><?= $x->datum_postavljanja ?></td>
                                                <td class="text-center"><a class="btn-potvrdiNek" href="/propertie-page.php?idProp=<?= $x->id_nekretnine ?>" id="realEstate" data-id="<?= $x->id_nekretnine ?>"><i class="fa fa-eye"></i></a></td>
                                                <td class="text-center"><a class="btn-obrisi adDelete" href="#" data-addelete="<?= $x->id_nekretnine ?>"><i class="fa fa-trash"></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <h4 class="text-center">Trenutno nema oglasa</h4>
                                    <?php endif; ?>  
                                        </tbody>
                                    </table>
                                </div>               
<?php
    include "templates/footer.php";
?>      