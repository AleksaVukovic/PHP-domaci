<?php

include "broker.php";

$broker=Broker::getBroker();

if(isset($_GET["metoda"])){
    if($_GET["metoda"]=="vratiSve"){
        $broker->vratiBioskope();
        posalji($broker);
    }
}
if(isset($_POST["metoda"])){
    if($_POST["metoda"]=="dodaj"){
        $naziv=$_POST["naziv"];
        $adresa=$_POST["adresa"];
    if(!validirajBioskop($naziv,$adresa)){
        echo "bioskop nije validan";
    }else{
        $broker->dodajBioskop($naziv,$adresa);
        if(!$broker->getRezultat()){
            echo "greska pri dodavanju";
        }else{
            echo "ok";
        }
    }
    }
    if($_POST["metoda"]=="izmeni"){
        $naziv=$_POST["naziv"];
        $adresa=$_POST["adresa"];
        $id=$_POST["id"];
        if(!validirajBioskop($naziv,$adresa)){
            echo "bioskop nije validan";
        }else{
            $broker->izmeniBioskop($id,$naziv,$adresa);
        if(!$broker->getRezultat()){
            echo "greska pri dodavanju";
        }else{
            echo "ok";
        }
        }
    }
    if($_POST["metoda"]=="obrisi"){
        $broker->obrisiBioskop($_POST["id"]);
        if(!$broker->getRezultat()){
            echo "greska pri brisanju";
        }else{
            echo "ok";
        }
    }
    if($_POST["metoda"]=="dodajVezu"){
        if(!intval($_POST["brojProjekcija"]) || intval($_POST["brojProjekcija"])<1){
            echo "Broj projekcija mora biti pozitivan broj";
        }else{
            $broker->dodajVezu($_POST["bioskop"],$_POST["film"],$_POST["brojProjekcija"]);
            if(!$broker->getRezultat()){
                echo "greska pri dodavanju";
            }else{
                echo "ok";
            }
        }
    }
    if($_POST["metoda"]=="obrisiVezu"){
        $broker->obrisiVezu($_POST["bioskop"],$_POST["film"]);
        if(!$broker->getRezultat()){
            echo "greska pri brisanju";
        }else{
            echo "ok";
        }
    }
}

function posalji($broker){
    $rezultat=$broker->getRezultat();
    $response=array();
    if(!$rezultat){
        $response["status"]="greska u bazi";
        
    }else{
        $response["status"]="ok";
        $response["data"]=array();
        while($red=$rezultat->fetch_object()){
            $response["data"][]=$red;
        }
    }
    echo json_encode($response);
}
function validirajBioskop($naziv,$adresa){
    $naziv=trim($naziv);
    $adresa=trim($adresa);
    return strlen($naziv)>3 && strlen($naziv)<40 && strlen($adresa)<40 && preg_match("/^[A-Za-z][A-Za-z\s]*([1-9][0-9]*|bb)$/",$adresa);
}
?>