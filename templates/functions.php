<?php
function existUsername($username){
    global $conn;
    $sql = "SELECT * FROM korisnik WHERE korisnicko_ime = :ime";

    $unos=$conn->prepare($sql);
    $unos->bindParam(":ime",$username);
    $unos->execute();
    $count=$unos->rowCount();
    if($count){
        return false;
    }else{
        return true;
    }
}
function insertValueSpecification($propertieId,$specId,$specValue){
    global $conn;
    $upit="INSERT INTO nekretnine_specifikacija(id_nekretnine,id_specifikacije,vrednost) VALUES (:pId,:specId,:specValue)";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":pId",$propertieId);
    $unos->bindParam(":specId",$specId);
    $unos->bindParam(":specValue",$specValue);

    $rezultat=$unos->execute();

    return $rezultat;
}
function existEmail($email){
    global $conn;
    $sql = "SELECT * FROM korisnik WHERE mail_adresa = :mail";

    $unos=$conn->prepare($sql);
    $unos->bindParam(":mail",$email);
    $unos->execute();

    $count=$unos->rowCount();

    if($count){
        return false;
    }else{
        return true;
    }
}

function registrationUser($name,$surname,$username,$email,$password,$vkey){
    global $conn;
    $upit="INSERT INTO korisnik(ime,prezime,korisnicko_ime,mail_adresa,lozinka,verifikacioni_kod) VALUES (:ime,:prezime,:k_ime,:mail,:lozinka,:kod)";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":ime",$name);
    $unos->bindParam(":prezime",$surname);
    $unos->bindParam(":k_ime",$username);
    $unos->bindParam(":mail",$email);
    $unos->bindParam(":lozinka",$password);
    $unos->bindParam(":kod",$vkey);

    $rezultat=$unos->execute();

    return $rezultat;
}
function registrationAgent($licence,$phone,$uId){
    global $conn;
    $upit="INSERT INTO agent(id_korisnik,broj_dozvole,broj_telefona) VALUES (:x,:dozvola,:telefon)";

    $unos=$conn->prepare($upit);
    $unos->bindParam(":x",$uId);
    $unos->bindParam(":dozvola",$licence);
    $unos->bindParam(":telefon",$phone);

    $result=$unos->execute();

    return $result;
}
function verificationUser($vkey){
    global $conn;
    $verikovan=0;
    $upit="SELECT verifikacioni_kod,verifikovan FROM korisnik WHERE verifikacioni_kod=:kod AND verifikovan=:v";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":v",$verikovan);
    $unos->bindParam(":kod",$vkey);
    $unos->execute();

    $rezultat=$unos->fetch();

    return $rezultat;
}
function updateUser($vkey){
    global $conn;
    $verikovan=0;
    $upit="UPDATE korisnik SET verifikovan=:v WHERE verifikacioni_kod=:kod";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":v",$verikovan);
    $unos->bindParam(":kod",$vkey);

    $rezultat=$unos->execute();

    return $rezultat;
}
function emptyInput($name,$surname,$username,$email,$password){
    $result;
    if(empty($name) && empty($surname) && empty($username) && empty($email) && empty($password)){
        $result=false;
    }
    else{
        $result=true;
    }
    return $result;
}
function invalidInput($field,$fieldReg){
    $result;
    if(preg_match($fieldReg,$field)){

        $result=true;
    }
    else{
        $result=false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $result=true;
    }
    else{
        $result=false;
    }
    return $result;
}
function emptyInputLog($username,$password){
    $result;
    if(empty($username) && empty($email)){
        $result=false;
    }
    else{
        $result=true;
    }
    return $result;
}
function emptyInputAgent($licence,$phone){
    $result;
    if(empty($licence)||empty($phone)){
        $result=true;
    }
    else{
        $result=false;
    }
    return $result;
}
function loginUser($username,$password){
    $result;
    $verifikovan=1;
    global $conn;
    $sql="SELECT * FROM korisnik k JOIN uloga u ON k.id_uloga = u.id_uloga WHERE k.korisnicko_ime = :username AND k.lozinka = :pass AND verifikovan=:verifikovan";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username",$username);
    $stmt->bindParam(":pass",$password);
    $stmt->bindParam(":verifikovan",$verifikovan);
    $stmt->execute();

    $result=$stmt->fetch();

    return $result;
}
function getUser($idUser){
    global $conn;
    $sql="SELECT * FROM korisnik k JOIN uloga u ON k.id_uloga=u.id_uloga WHERE k.id_korisnik= :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id",$idUser);

    $stmt->execute();
    return $stmt->fetch();
}
function getAgentRequest($x){
    global $conn;
    $sql="SELECT * FROM korisnik k INNER JOIN agent a ON k.id_korisnik=a.id_korisnik WHERE odobren=$x;";
    
    $result=$conn->query($sql);
    $data=$result->fetchAll();
    return $data;
}
function agentDenied($id){
    global $conn;
    $sql="DELETE FROM agent WHERE id_agent=:agent";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":agent",$id);
    
    $result=$stmt->execute();

    return $result;
}
function agentApproved($id){
    global $conn;
    $sql="UPDATE agent SET odobren = 1 WHERE id_agent = :agent";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":agent",$id);
    
    $result=$stmt->execute();

    return $result;
}
function getAllUsers(){
    global $conn;
    $sql="SELECT * FROM korisnik k JOIN uloga u on k.id_uloga=u.id_uloga WHERE verifikovan=1";

    $result=$conn->query($sql);
    $data=$result->fetchAll();
    return $data;
}
function getNumber($x){
    global $conn;

    $sql="SELECT * FROM $x WHERE odobren = 1";
    $result=$conn->query($sql);
    $count=$result->rowCount();
    
    return $count;
}
function userAgent($username){
    global $conn;

    $sql="SELECT * FROM korisnik k JOIN agent a ON k.id_korisnik = a.id_korisnik WHERE k.korisnicko_ime = :username";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":username",$username);

    $stmt->execute();
    $result=$stmt->fetch();

    return $result;

}
function GetAll($nameTable){
    
        global $conn;
        $upit = "SELECT * FROM $nameTable";
        $podaci = $conn->query($upit)->fetchAll();
        return $podaci;
   
}


define("OFFSET", 6);
function GetAllProperties($objekat=['prazan'=>"true"],$limit=0) {
    global $conn;

    $select;
    $limit=((int) $limit) * OFFSET;
    $offset=OFFSET;
    $upit="";
            
    if ($objekat["prazan"]=="false"){
        $tabele = "";
        $uslovi = [];
        $i=0;
        foreach ($objekat as $key=>$value) {
            if (count((array)$value) && $key != "prazan") {
                $kolona = "id_".$key;
                $alias = mb_substr($key, 0, 1); 

                

                $tabele .= "JOIN $key $alias ON n.$kolona = $alias.$kolona ";
                if (count($value) > 1)
                    $uslovi[$i++] = "$alias.$kolona IN (".join(", ", $value).")";
                else
                    $uslovi[$i++] = "$alias.$kolona = ".$value[0];

            }
        }
        
        if (!str_contains($tabele, "JOIN grad g")) $tabele .= "JOIN grad g ON n.id_grad = g.id_grad";
        $upit = "SELECT * FROM nekretnine n $tabele WHERE n.odobren = 1 AND ".implode(" AND ",$uslovi);
    }
    else {
        $upit = "SELECT * FROM nekretnine n JOIN grad g ON n.id_grad = g.id_grad  WHERE n.odobren = 1";
    }

    $upit.=" LIMIT :limit,:offset";

    $select=$conn->prepare($upit);
    $select->bindParam(":limit",$limit,PDO::PARAM_INT);
    $select->bindParam(":offset",$offset,PDO::PARAM_INT);
    
    $select->execute();

    $podaci=$select->fetchAll();


    return $podaci;
}


function getAllImages(){
    global $conn;
    $upit = "SELECT sn.id_slika,sn.slika_putanja,sn.id_nekretnine,n.id_nekretnine FROM slike_nekretnina sn RIGHT JOIN nekretnine n ON sn.id_nekretnine=n.id_nekretnine";
    $podaci = $conn->query($upit)->fetchAll();
    
    
    return $podaci;
}

function advertisementApprove($inactive){
    global $conn;

    
    $upit = "SELECT * FROM nekretnine n JOIN grad g ON n.id_grad=g.id_grad JOIN agent a ON n.id_agent=a.id_agent JOIN korisnik k ON a.id_korisnik=k.id_korisnik WHERE n.odobren=:inactive ";

    $stmt=$conn->prepare($upit);
    $stmt->bindParam(':inactive',$inactive);
    $stmt->execute();
    $podaci=$stmt->fetchAll();

    return $podaci;
}


function infoActive($id){
    global $conn;

    $sql="SELECT odobren FROM nekretnine WHERE id_nekretnine=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id);

    $stmt->execute();
    $data=$stmt->fetch();

    return $data;
}


function getSpecificationType($id){
    
    global $conn;
    $upit = "SELECT * FROM specifikacija WHERE id_tip= :id";

    $stmt=$conn->prepare($upit);
    $stmt->bindParam(":id",$id);
    
    $stmt->execute();
    $result=$stmt->fetchAll();

    return $result;
}

function insertPropertie($description,$transaction,$agent,$city,$price,$type,$naziv){
    global $conn;
    $upit="INSERT INTO nekretnine(opis,id_struktura,id_agent,id_grad,cena,id_tip,naziv) VALUES (:opis,:struktura,:agent,:grad,:cena,:tip,:naziv)";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":opis",$description);
    $unos->bindParam(":struktura",$transaction);
    $unos->bindParam(":agent",$agent);
    $unos->bindParam(":grad",$city);
    $unos->bindParam(":cena",$price);
    $unos->bindParam(":tip",$type);
    $unos->bindParam(":naziv",$naziv);

    $rezultat=$unos->execute();

    return $rezultat;
}

function lastIndexProperties(){
    global $conn;
    $upit = "SELECT MAX(id_nekretnine) as last FROM nekretnine";
    $podaci = $conn->query($upit)->fetch();
    $max=$podaci->last;
    
    return $max;

}

function getUserProperties($id){
    global $conn;
    $upit = "SELECT * FROM nekretnine WHERE id_agent= :id";

    $stmt=$conn->prepare($upit);
    $stmt->bindParam(":id",$id);
    
    $stmt->execute();
    $result=$stmt->fetchAll();

    return $result;
}

function getFullInfoProp($id){
    global $conn;
    
    $upit = "SELECT * FROM nekretnine n JOIN agent a ON n.id_agent=a.id_agent JOIN korisnik k ON a.id_korisnik=k.id_korisnik JOIN grad g ON n.id_grad=g.id_grad JOIN tip t ON n.id_tip=t.id_tip JOIN struktura s ON n.id_struktura=s.id_struktura WHERE n.id_nekretnine=:id";

    $stmt=$conn->prepare($upit);
    $stmt->bindParam(":id",$id);
    
    $stmt->execute();
    $result=$stmt->fetch();

    return $result;
    
   
}

function getFullSpecification($id){
    global $conn;
    
    $upit="SELECT naziv_specifikacija,vrednost FROM nekretnine n JOIN nekretnine_specifikacija sn ON n.id_nekretnine=sn.id_nekretnine JOIN specifikacija s ON sn.id_specifikacije=s.id_specifikacija WHERE n.id_nekretnine=:id";

    $stmt=$conn->prepare($upit);
    $stmt->bindParam(":id",$id);
    
    $stmt->execute();
    $result=$stmt->fetchAll();

    return $result;
    
   
}

function getSchedule(){
    global $conn;
    $upit = "SELECT * FROM termini";
    $podaci = $conn->query($upit)->fetchAll();
    
    
    return $podaci;
}

function existAppointmentForAgent($scheduleId,$date,$agent){

    global $conn;

    $sql="SELECT * FROM zakazivanje WHERE id_termin=:sccheduleId AND datum_zakazivanja=:datePick AND id_agent=:agentId";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":sccheduleId",$scheduleId);
    $stmt->bindParam(":datePick",$date);
    $stmt->bindParam(":agentId",$agent);

    $stmt->execute();
    $result=$stmt->fetch();

    return $result;

}

function existAppointmentForEstate($scheduleId,$date,$propertie){
    global $conn;

    $sql="SELECT * FROM zakazivanje WHERE id_termin=:sccheduleId AND datum_zakazaivanja=:datePick AND id_nekretnine=:nekretninaId";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":sccheduleId",$scheduleId);
    $stmt->bindParam(":datePick",$date);
    $stmt->bindParam(":nekretninaId",$propertie);

    $stmt->execute();
    $result=$stmt->fetch();

    return $result;
}

function insertAppointment($date,$userId,$agent,$propertie,$scheduleId){
    global $conn;
    $upit="INSERT INTO zakazivanje(id_termin,datum_zakazivanja,id_korisnik,id_nekretnine,id_agent) VALUES (:termin,:datum,:korisnik,:nekretnina,:agent)";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":termin",$scheduleId);
    $unos->bindParam(":datum",$date);
    $unos->bindParam(":korisnik",$userId);
    $unos->bindParam(":nekretnina",$propertie);
    $unos->bindParam(":agent",$agent);

    $rezultat=$unos->execute();

    return $rezultat;
}

function getInfoSchedule($idUser){
    global $conn;

    $sql="SELECT n.naziv,z.datum_zakazivanja,t.termin FROM zakazivanje z JOIN nekretnine n ON z.id_nekretnine=n.id_nekretnine JOIN termini t ON z.id_termin=t.id_termin WHERE z.id_korisnik=:user";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":user",$idUser);

    $stmt->execute();
    $result=$stmt->fetchAll();

    return $result;
}

function getFullList($active){
    global $conn;
    $sql = "SELECT n.id_nekretnine,n.naziv,n.datum_postavljanja,k.ime,k.prezime FROM nekretnine n JOIN agent a ON n.id_agent=a.id_agent JOIN korisnik k ON a.id_korisnik=k.id_korisnik WHERE n.odobren=:active";
    
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":active",$active);
    $stmt->execute();
    $data=$stmt->fetchAll();
    
    
    return $data;

}
function getPageNumber(){
    global $conn;
    $upit="SELECT COUNT(*) as number FROM nekretnine";

    $podaci=$conn->query($upit)->fetch();
    return $podaci;
}

function vratiBrojStranica(){
    $brojFilmova=getPageNumber();

    $broj=ceil($brojFilmova->number / OFFSET);

    return $broj;
}

function setMessage($nameMssg,$text){
    $_SESSION[$nameMssg]=$text;
}

function displayMessage($name){
    if(isset($_SESSION[$name])){
        echo "<p class='error mb-2'>$_SESSION[$name]</p>";
        unset($_SESSION[$name]);
    }
}

function deleteProfile($id){
    global $conn;

    $sql="DELETE FROM korisnik WHERE id_korisnik=:id";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id);
    
    $result=$stmt->execute();

    return $result;
}

function emptyInputForUpdate($name,$surname,$username,$email){
    $result;
    if(empty($name) && empty($surname) && empty($username) && empty($email)){
        $result=false;
    }
    else{
        $result=true;
    }
    return $result;
}

function updateProfile($name,$lastName,$mail,$username,$id){
    global $conn;
    $upit="UPDATE korisnik 
           SET ime=:ime,
               prezime=:prezime,
               mail_adresa=:mail,
               korisnicko_ime=:username 
           WHERE id_korisnik=:id;";

    $stmt = $conn->prepare($upit);

    $stmt->bindParam(":ime",$name, PDO::PARAM_STR);
    $stmt->bindParam(":prezime",$lastName, PDO::PARAM_STR);
    $stmt->bindParam(":mail",$mail, PDO::PARAM_STR);
    $stmt->bindParam(":username",$username, PDO::PARAM_STR);
    $stmt->bindParam(":id",$id,PDO::PARAM_INT);

    $rezultat=$stmt->execute();

    return $rezultat;
}

function newslatterInsert($email){
    global $conn;

    $upit="INSERT INTO newslatter(mail_adresa) VALUES (:mail)";

    $stmt=$conn->prepare($upit);
    $stmt->bindParam(":mail",$email);

    $result=$stmt->execute();

    return $result;
}

function getscheduledTime($id){
    global $conn;

    $sql="SELECT k.ime,k.prezime,t.termin,n.naziv,z.datum_zakazivanja FROM zakazivanje z JOIN termini t ON z.id_termin=t.id_termin JOIN korisnik k ON z.id_korisnik=k.id_korisnik JOIN nekretnine n ON z.id_nekretnine=n.id_nekretnine WHERE z.id_agent=:idAgent;";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":idAgent",$id);

    $stmt->execute();
    $result=$stmt->fetchAll();

    return $result;
    

}

function sendMessage($firstName,$lastName,$headline,$message){
    global $conn;

    $sql="INSERT INTO kontakt(ime,prezime,naslov,tekst) VALUES(:ime,:prezime,:naslov,:tekst)";

    $stmt=$conn->prepare($sql);

    $stmt->bindParam(':ime',$firstName);
    $stmt->bindParam(':prezime',$lastName);
    $stmt->bindParam(':naslov',$headline);
    $stmt->bindParam(':tekst',$message);

    $result=$stmt->execute();

    return $result;
}

function uploadProfilePicture($filePath,$id){
    global $conn;
    $sql="UPDATE korisnik SET profilna_slika=:pathImg WHERE id_korisnik=:id";
    $stmt=$conn->prepare($sql);

    
    $stmt->bindParam(":pathImg",$filePath);
    $stmt->bindParam(":id",$id);

    $result=$stmt->execute();

    return $result;
}

function uploadAdPicture($filePath,$id){
    global $conn;
    $sql="INSERT INTO slike_nekretnina(slika_putanja,id_nekretnine) VALUES(:pathImg,:id)";
    $stmt=$conn->prepare($sql);

    
    $stmt->bindParam(":pathImg",$filePath);
    $stmt->bindParam(":id",$id);

    $result=$stmt->execute();

    return $result;
}

function getPictures($id){
    global $conn;
    $sql="SELECT * FROM slike_nekretnina WHERE id_nekretnine=:id";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id);

    $stmt->execute();
    $result=$stmt->fetchAll();

    return $result;
}

function getAllPic(){
    global $conn;
    $upit = "SELECT * FROM slike_nekretnina";
    $podaci = $conn->query($upit)->fetchAll();
    
    
    return $podaci;
}

function getIds(){
    global $conn;
    $sql="SELECT id_nekretnine FROM nekretnine";

    $data=$conn->query($sql)->fetchAll();

    return $data;
}

function getAddForChange($id){
    global $conn;

    $sql="SELECT * FROM nekretnine n JOIN nekretnine_specifikacija ns ON n.id_nekretnine=ns.id_nekretnine WHERE n.id_nekretnine=:id";

    $stmt=$conn->prepare($sql);

    $stmt->bindParam(":id",$id);
    $stmt->execute();

    $result=$stmt->fetch();

    return $result;

}

function getTypeSpec($typeId,$id){
    global $conn;
    $sql="SELECT * FROM nekretnine_specifikacija ns JOIN specifikacija s ON ns.id_specifikacije=s.id_specifikacija WHERE ns.id_nekretnine=:id AND s.id_tip=:typeId";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id);
    $stmt->bindParam("typeId",$typeId);
    $stmt->execute();

    $result=$stmt->fetchAll();
    return $result;
}

function updateAd($adId,$name,$cityId,$transaction,$price){
    global $conn;

    
    $upit="UPDATE nekretnine
           SET naziv=:naziv,
               id_grad=:id_grad,
               id_struktura=:id_struktura,
               cena=:cena 
           WHERE id_nekretnine=:id;";

    $stmt = $conn->prepare($upit);

    $stmt->bindParam(":naziv",$name);
    $stmt->bindParam(":id_grad",$cityId);
    $stmt->bindParam(":id_struktura",$transaction);
    $stmt->bindParam(":cena",$price);
    $stmt->bindParam(":id",$adId);

    $rezultat=$stmt->execute();

    return $rezultat;

}

function getAgent($idAgent){
    global $conn;
    $sql="SELECT * FROM agent WHERE id_agent=:id";
    $stmt=$conn->prepare($sql);

    $stmt->bindParam(":id",$idAgent);
    $stmt->execute();

    $result=$stmt->fetch();

    return $result;

}

function agentUpdate($idAgent,$phone){
    global $conn;

    $sql="UPDATE agent SET broj_telefona=:phone WHERE id_agent=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':phone',$phone);
    $stmt->bindParam(':id',$idAgent);

    $result=$stmt->execute();
    return $result;
}

function activeAgent($id,$active){
    global $conn;

    $sql="UPDATE agent SET odobren=:active WHERE id_agent=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':active',$active);
    $stmt->bindParam(':id',$id);

    $result=$stmt->execute();
    return $result;

}

function approveAd($id,$active){
    global $conn;

    $sql="UPDATE nekretnine SET odobren=:active WHERE id_nekretnine=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':active',$active);
    $stmt->bindParam(':id',$id);

    $result=$stmt->execute();
    return $result;
}

function adDelete($id){
    global $conn;
    $sql="DELETE FROM nekretnine WHERE id_nekretnine=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $result=$stmt->execute();

    return $result;
}

function userDelete($id){
    global $conn;
    $sql="DELETE FROM korisnik WHERE id_korisnik=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $result=$stmt->execute();

    return $result;
}

function getUnreadMessages($unread){
    global $conn;
    $sql="SELECT COUNT(*) as broj FROM kontakt WHERE procitano=:unread";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':unread',$unread);

    $stmt->execute();

    $data=$stmt->fetch();
    return $data;
}

function getOneMessage($id){
    global $conn;
    $sql="SELECT * FROM kontakt WHERE id_poruke=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);

    $stmt->execute();

    $data=$stmt->fetch();
    return $data;
}

function messageRead($id,$read){
    global $conn;

    $sql="UPDATE kontakt SET procitano=:procitano WHERE id_poruke=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':procitano',$read);
    $stmt->bindParam(':id',$id);

    $result=$stmt->execute();
    return $result;
}

function deleteMessage($id){
    global $conn;
    $sql="DELETE FROM kontakt WHERE id_poruke=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $result=$stmt->execute();

    return $result;
}


function updateProfileForAdmin($id,$firstName,$lastName,$username,$email,$pathForDB){
    global $conn;
    $upit="UPDATE korisnik 
           SET ime=:ime,
               prezime=:prezime,
               mail_adresa=:mail,
               korisnicko_ime=:username,
               profilna_slika=:profilna
           WHERE id_korisnik=:id;";

    $stmt = $conn->prepare($upit);

    $stmt->bindParam(":ime",$firstName);
    $stmt->bindParam(":prezime",$lastName);
    $stmt->bindParam(":username",$username);
    $stmt->bindParam(":mail",$email);
    $stmt->bindParam(":profilna",$pathForDB);
    $stmt->bindParam(":id",$id);

    $rezultat=$stmt->execute();

    return $rezultat;
}

function existProfilePicture($id){
    global $conn;

    $sql="SELECT profilna_slika FROM korisnik WHERE id_korisnik=:id";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    $path=$stmt->fetch();

    return $path;
}
function deleteAdForUser($id,$idAgent){
    global $conn;
    $sql="DELETE FROM nekretnine WHERE id_agent=:agent AND id_nekretnine=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':agent',$idAgent);
    $stmt->bindParam(':id',$id);
    $result=$stmt->execute();

    return $result;
}
            
function getFullListAdForOneUser($idAgent){
     global $conn;
            
     $sql="SELECT * FROM nekretnine WHERE id_agent=:id";
            
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$idAgent);
    $stmt->execute();
            
    $data=$stmt->fetchAll();
            
     return $data;
}

function getPullQuestionAndAnswer(){

    global $conn;
    $sql="SELECT * FROM anketa_pitanja_odgovori apo JOIN anketa_pitanja p ON apo.id_pitanje=p.id_pitanja JOIN anketa_odgovori o ON apo.id_odgovor=o.id_odgovor ORDER BY apo.id_pitanje ASC";

    $data=$conn->query($sql)->fetchAll();

    return $data;
}

function answeredPoll($idUser,$answer){
    global $conn;
    $upit="INSERT INTO anketa_korisnik(id_pitanjeodgovor,id_korisnik) VALUES (:answer,:id)";

    $unos = $conn->prepare($upit);
    $unos->bindParam(":answer",$answer);
    $unos->bindParam(":id",$idUser);

    $rezultat=$unos->execute();

    return $rezultat;
}

function existAnswer($id){
    global $conn;
            
    $sql="SELECT * FROM anketa_korisnik WHERE id_korisnik=:id";
            
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    $result=$stmt->fetchAll();
            
    return $result;
}

function existLicenceNumber($licence){
    global $conn;
            
    $sql="SELECT * FROM agent WHERE broj_dozvole=:licence";
            
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':licence',$licence);
    $stmt->execute();

    $result=$stmt->fetchAll();

    if(count($result)){
        return false;
    }
    else{
        return true;
    }
}