<?php
    include "templates/head.php";
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $message=getOneMessage($id);
        $read=1;
        $messageRead=messageRead($id,$read);
    }

?>  
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 mb-0 text-gray-800">Poruka od <?= $message->ime. " " .$message->prezime ?></h2>
                    </div>
                    <div class="table-responsive table--no-card m-b-30 mt-5">
                        <table class="table bg-message">
                            <thead>
                                <tr class="red">
                                    <th class="colorHead">Naslov:</th>
                                    <th><?= $message->naslov ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="red">
                                    <th class="colorHead">Tekst:</th>
                                    <th><?= $message->tekst ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
<?php
    include "templates/footer.php";
?>  