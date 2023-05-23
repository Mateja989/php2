<?php

define("SERVER", "localhost");
define("DATABASE", "id18884428_nekretnineapp");
define("USERNAME", "id18884428_nekretnineuser");
define("PASSWORD", "5u#8~wt737%d4WIN");
try {
    $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);

    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
    echo $ex->getMessage();
}