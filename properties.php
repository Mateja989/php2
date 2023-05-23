<?php
    include "templates/head.php";
    include "templates/navigation.php";
    $properties=getAllProperties();
    $city=GetAll('grad');
    $transaction=GetAll('struktura');
    $type=GetAll('tip');
    $picture=getAllImages();
?>
        <main>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 mt-5">
                        <ul class="d-flex stay">
                            <li>Početna</li>
                            <span><li>/</li></span>
                            <li>Oglasi</li>
                        </ul>
                    </div>
                    <h1>Nekretnine</h1>
                </div>
            </div>
            <hr class="line"/>
            <div class="container bor">
                <div class="row justify-content-around">
                    <div class="main-properties order-2 order-md-1" id='realEstates'>
                        <?php foreach($properties as $propertie): ?>
                                <div class="cart-properties">
                                    <div class='img-cart'>
                                    <?php foreach($picture as $pic): ?>
                                        <?php if($pic->id_nekretnine == $propertie->id_nekretnine): ?>
                                            <?php if($pic->slika_putanja != NULL): ?>
                                                <img src="<?= $pic->slika_putanja?>" alt="">
                                                <?php break; ?>
                                            <?php else: ?>
                                                <img src="assets/img/no img.png" alt="">
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                    <div class="body-cart">
                                        <h3><a href="propertie-page.php?idProp=<?= $propertie->id_nekretnine?>" id="realEstate" data-id="<?=$propertie->id_nekretnine?>"
                                        ><?= $propertie->naziv ?></a></h3>
                                        <p><?= $propertie->naziv_grad ?></p>
                                        <h4><?= $propertie->cena.",00 EUR" ?></h4>
                                    </div>
                                </div>
                        <?php endforeach; ?> 
                        <div class="number">
                            <?php 
                                $nekretnineBroj=vratiBrojStranica();

                                
                            ?>
                            <ul class="page-number" id="paginacija">
                                <?php
                                    for($i=0;$i<$nekretnineBroj;$i++):
                                ?>
                                <span><li><a class="pagination" data-limit="<?=$i?>" href=""><?=($i+1)?></a></li></span>
                                <?php 
                                    endfor;
                                ?>
                            </ul>
                        </div>                         
                    </div>
                    <div class="sidebar order-1 order-md-2">
                        <div class="search">
                            <h3>Pretraži</h3>
                            <form action="" method="post" id="filter-form">
                                <h4 class="filterHeadline">Tip</h4>
                                <?php foreach($type as $x): ?>
                                    <div class="filterTag">
                                        <input type="checkbox" class="type" name = "tip" value="<?=$x->id_tip?>"/>
                                        <label for="type"><?=$x->naziv_tip?></label>
                                    </div>
                                <?php endforeach; ?>
                                <h4 class="filterHeadline">Trasakcija</h4>
                                <?php foreach($transaction as $x): ?>
                                    <div class="filterTag">
                                        <input type="checkbox" class="transaction" name = "struktura" value="<?=$x->id_struktura?>" />
                                        <label for="transaction"><?=$x->naziv_strukture?></label>
                                    </div>
                                <?php endforeach; ?>
                             <h4 class="filterHeadline">Grad</h4>
                               <?php foreach($city as $x): ?>
                                    <div class="filterTag">
                                        <input type="checkbox" class="city" name = "grad" value="<?=$x->id_grad?>">
                                        <label for="city"><?=$x->naziv_grad?></label>
                                    </div>
                                <?php endforeach; ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?php
    include "templates/footer.php";
?>

