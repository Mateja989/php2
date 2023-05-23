<?php
    include "templates/head.php";
    require_once "../templates/functions.php";
    $users=getAllUsers();
?>
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Spisak svih registrovanih korisnika</h2>
                    </div>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr class="red">
                                                <th >Ime i prezime</th>
                                                <th>Id</th>
                                                <th>Email</th>
                                                <th class="text-right">Datum kreiranja</th>
                                                <th class="text-right">Status</th>
                                                <th class="text-center">Obrisi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="allUsers">
                                        <?php if(count($users)): ?>
                                        <?php foreach($users as $user): ?>
                                            <tr class="red">
                                                <td><?= $user->ime. " " .$user->prezime ?></td>
                                                <td><?= $user->id_korisnik ?></td>
                                                <td><?= $user->mail_adresa ?></td>
                                                <td class="text-right"><?= $user->datum_kreiranja_profila ?></td>
                                                <td class="text-right"><?= $user->naziv_uloga ?></td>
                                                <td class="text-center"><a class="btn-obrisi deleteUser" href="#" data-userdelete="<?= $user->id_korisnik ?>"><i class="fa fa-trash"></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <h4 class="text-center">Trenutno ne postoji registrovan korisnik</h4>
                                    <?php endif; ?>  
                                        </tbody>
                                    </table>
                                </div>               
<?php
    include "templates/footer.php";
?>               