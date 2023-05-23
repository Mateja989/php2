<?php
    include "templates/head.php";
    $active=1;
    $propertiesList=getFullList($active);
    $poll=getPullQuestionAndAnswer();
    function brojGlasova($idPitanja,$idOdgovor){

        global $conn;
        $sql="SELECT * FROM anketa_korisnik ak JOIN anketa_pitanja_odgovori apo ON ak.id_pitanjeodgovor=apo.id_apo WHERE apo.id_pitanje=:pitanje AND apo.id_odgovor=:odgovor";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':pitanje',$idPitanja);
        $stmt->bindParam(':odgovor',$idOdgovor);

        $stmt->execute();

        $result=$stmt->fetchAll();
        $broj=count($result);
        return $broj;
    }
    function vratiOdgovore($niz, $idPitanje) {
      $s = "";
      foreach($niz as $el) {
          if ($el->id_pitanje == $idPitanje)
              $s .="<div><label>$el->tekst_odgovor(".brojGlasova($el->id_pitanje,$el->id_odgovor).")</label></div>";
      }
      return $s;
    }
?>  
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Statistika ankete i broj odgovora</h2>
                    </div>
                    <div class="table-responsive table--no-card m-b-30">
                                <table class="table table-borderless table-striped table-earning">
                                        <tbody id="adFullList">
                                            <tr class="red">
                                                <?php $pitanjeID = -1; ?>
                                                    <?php foreach($poll as $el): ?>
                                                    <?php if($pitanjeID!=$el->id_pitanje): ?>
                                                    <div class="pollAnswer col-lg-6 col-md-12 mt-3">
                                                    <h4><?= $el->tekst_pitanja ?></h4>
                                                    <?php $pitanjeID=$el->id_pitanje; ?>
                                                    <?php echo (vratiOdgovore($poll, $pitanjeID)); ?>
                                                    </div>
                                                    <?php else: continue; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>               

                                     
<?php
    include "templates/footer.php";
?> 