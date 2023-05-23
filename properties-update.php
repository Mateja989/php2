<?php
    include "templates/head.php";
    include "templates/navigation.php"
    $transactions=GetAll('struktura');
    $cities=GetAll('grad');
    $types=GetAll('tip');
    if(isset($_GET['idchange'])){
        $id=$_GET['idchange'];
        $infoAd=getAddForChange($id);
        $typeId=$infoAd->id_tip;
        $specifications=getTypeSpec($typeId,$id);
    }

    if(isset($_POST['changeBtn'])){
        $adId=$_GET['idchange'];
        $name=$_POST['adName'];
        $cityId=$_POST['city'];
        $transactionId=$_POST['transaction'];
        $type=$_POST['type'];
        $price=$_POST['price'];
        $description=$_POST['description'];
        $errors=[];

        $priceRegEx="/^[\d]{1,10}$/";
        $propertieNameRegEx="/[\w\s]{5,50}/";

        if(!invalidInput($price,$priceRegEx)){
            $errors['price']="Cena nije u dobrom formatu.";
        }
        if(!invalidInput($name,$propertieNameRegEx)){
            $errors['ad']="Naziv oglasa nije u dobrom formatu,mora započeti velikim slovom.";
        }

        if(count($errors)==0){
            $update=updateAd($adId,$name,$cityId,$transactionId,$price);
        
                if($update){
                    $success['uspeh']="Uspesno ste izvrsili sve izmene";
                }else{}
            
        }
    }

?>
<main>
      <div class="container boja">
        <div class="row">
          <form action="properties-update.php?idchange=<?=$infoAd->id_nekretnine?>" method="post" id="forma" >
            <div class="col-5">
              <h4 class="text-right mb-3">Nekretnina oglas</h4>
              <div class="col-md-12">
                <label class="labels">Naslov oglasa</label>
                <input type="text" class="form-control" name="adName" value="<?= isset($name)?$name : $infoAd->naziv ?>" id="propertie-name">
                <?php if(isset($errors['ad'])): ?>
                    <p class="error"><?= $errors['ad'] ?></p>
                <?php endif; ?>
              </div>
              <div class="col-md-12">
                <label class="labels">Grad</label>
                <select name="city" id="ddl-city" class="form-control" >
                  <?php foreach($cities as $city): ?>
                    <?php if($city->id_grad==$infoAd->id_grad): ?>
                    <option value="<?= $city->id_grad ?>" selected><?= $city->naziv_grad ?></option>
                    <?php else: ?>
                    <option value="<?= $city->id_grad ?>"><?= $city->naziv_grad ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
                <p class="error mm-b hidden">Grad mora biti izabran</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Struktura oglasa</label>
                <select name="transaction" id="ddl-transaction-type" class="form-control" >
                  <?php foreach($transactions as $transaction): ?>
                    <?php if($transaction->id_struktura==$infoAd->id_struktura): ?>
                    <option value="<?= $transaction->id_struktura ?>" selected><?= $transaction->naziv_strukture ?></option>
                    <?php else: ?>
                    <option value="<?= $transaction->id_struktura ?>"><?= $transaction->naziv_strukture ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
                <p class="error mm-b hidden">Tip transakcije mora biti izabran</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Tip nekretnine</label>
                <select name="type" id="ddl-type" class="form-control" readonly>
                  <?php foreach($types as $type): ?>
                    <?php if($type->id_tip==$infoAd->id_tip): ?>
                    <option value="<?= $type->id_tip ?>"><?= $type->naziv_tip ?></option>
                    <?php break; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
                <p class="error mm-5 hidden">Tip nekretnine mora biti izabran</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Cena</label>
                <input type="text" class="form-control" name="price" value="<?= isset($price)?$price : $infoAd->cena ?>"  id="price">
                <?php if(isset($errors['price'])): ?>
                    <p class="error"><?= $errors['price'] ?></p>
                <?php endif; ?>
              </div>
              <div class="col-md-12">
                <label class="labels">Opis</label>
                <textarea class="form-control" rows="4" cols="50" name="description" id="description" value="">
                    <?= $infoAd->opis ?>
                </textarea>
                <p class="error mm-b hidden">Opis ne sme biti duži od 1000 karaktera</p>
              </div>
            </div>
            <div class="col-5" id="specifications">
                <h4 class="text-right mb-3">Specifikacije</h4>
                <?php foreach($specifications as $spec): ?>
                    <div class="col-md-12 mb-3">
                        <label class="labels"><?= $spec->naziv_specifikacija ?></label>
                        <input type="hidden" class="form-control" name="<?=$spec->naziv_specifikacija."ID" ?>"  value="<?= $spec->id_specifikacija ?>"/>
                        <input type="text" class="form-control" name="<?=$spec->naziv_specifikacija ?>"  value="<?= $spec->vrednost ?>"/>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class="col-11">
              <input type="submit" class="btn-izmeniA" value="Izmeni oglas" name="changeBtn" id="btn-confirm-propertie">
              <?php if(isset($success['uspeh'])): ?>
                <p class="text-center success"><?= $success['uspeh'] ?></p>
              <?php endif; ?>
            </div>
          </form>
          <div id="#odgovor">

          </div>
        </div>
      </div>
    </main>
<?php
    include "templates/footer.php";
?>