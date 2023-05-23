<?php
    include "templates/head.php";
    include "templates/navigation.php";

    $types=GetAll('tip');
    $transactions=GetAll('struktura');
    $cities=GetAll('grad');
?>
<main>
      <div class="container boja">
        <div class="row">
          <form action="" id="forma">
            <div class="col-5">
              <h4 class="text-right mb-3">Nekretnina oglas</h4>
              <div class="col-md-12">
                <label class="labels">Naslov oglasa</label>
                <input type="text" class="form-control" value="" id="propertie-name">
                <p class="error mm-b hidden">Naslov oglasa ne sme biti duži od 255 karaktera i mora početi velikim slovom</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Grad</label>
                <select name="" id="ddl-city" class="form-control" >
                  <option value="">Izaberite</option>
                  <?php foreach($cities as $city): ?>
                    <option value="<?= $city->id_grad ?>"><?= $city->naziv_grad ?></option>
                  <?php endforeach; ?>
                </select>
                <p class="error mm-b hidden">Grad mora biti izabran</p>
              </div>
              <?php if(isset($_SESSION['agent'])): ?>
                <input type="hidden" class="form-control" value="<?= $_SESSION['agent'] -> id_agent  ?>" id="agent-id" readonly/>
              <?php endif; ?>
              <div class="col-md-12">
                <label class="labels">Struktura oglasa</label>
                <select name="" id="ddl-transaction-type" class="form-control" >
                  <option value="">Izaberite</option>
                  <?php foreach($transactions as $transaction): ?>
                    <option value="<?= $transaction->id_struktura ?>"><?= $transaction->naziv_strukture ?></option>
                  <?php endforeach; ?>
                </select>
                <p class="error mm-b hidden">Tip transakcije mora biti izabran</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Tip nekretnine</label>
                <select name="" id="ddl-type" class="form-control" >
                  <option value="">Izaberite</option>
                  <?php foreach($types as $type): ?>
                    <option value="<?= $type->id_tip ?>"><?= $type->naziv_tip ?></option>
                  <?php endforeach; ?>
                </select>
                <p class="error mm-5 hidden">Tip nekretnine mora biti izabran</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Cena</label>
                <input type="text" class="form-control" value=""  id="price">
                <p class="error mm-b hidden">Cena mora biti uneta i zahteva format od maksimalno 10 cifara</p>
              </div>
              <div class="col-md-12">
                <label class="labels">Opis</label>
                <textarea class="form-control" rows="4" cols="50" id="description"></textarea>
                <p class="error mm-b hidden">Opis ne sme biti duži od 1000 karaktera</p>
              </div>
            </div>
            <div class="col-5" id="specifications">
                <h4 class="text-right mb-3">Specifikacije</h4>
              <p>Nije izabran tip nekretnine</p>
             
            </div>
            <div class="col-11">
              <input type="button" class="btn-izmeniA" value="Postavi oglas" id="btn-confirm-propertie">
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
