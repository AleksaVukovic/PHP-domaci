<?php
include "broker.php";

$broker=Broker::getBroker();

if(isset($_GET["metoda"])){
    if($_GET["metoda"]=="vrati sve"){
        $broker->vratiSveFilmove();
        posalji($broker);
    }
    if($_GET["metoda"]=="vrati iz bioskopa"){
        $broker->vratiSveFilmoveIzBioskopa($_GET["bioskop"]);
        posalji($broker);
    }
    if($_GET["metoda"]=="vrati kategorije"){
        $broker->vratiSveKategorije();
        posalji($broker);
    }
}
if(isset($_POST["metoda"])){
    if($_POST["metoda"]=="dodaj"){
        $naziv=$_POST["naziv"];
        $kategorija=$_POST["kategorija"];
        $brojMinuta=$_POST["broj_minuta"];
        if(!validirajFilm($naziv,$kategorija,$brojMinuta)){
            echo "Film nije validan";
        }else{
            $broker->dodajFilm($naziv,$kategorija,$brojMinuta);
            if(!$broker->getRezultat()){
                echo "greska u bazi";
            }else{
                echo "uspesno dodat film";
            }
        }
    }
    if($_POST["metoda"]=="izmeni"){
        $id=$_POST["id"];
        $naziv=$_POST["naziv"];
        $kategorija=$_POST["kategorija"];
        $brojMinuta=$_POST["broj_minuta"];
        if(!validirajFilm($naziv,$kategorija,$brojMinuta)){
            echo "Film nije validan";
        }else{
            $broker->izmeniFilm($id,$naziv,$kategorija,$brojMinuta);
            if(!$broker->getRezultat()){
                echo "greska u bazi";
            }else{
                echo "uspesno izmenjen film";
            }
        }
    }
    if($_POST["metoda"]=="obrisi"){
        $broker->obrisiFilm($_POST["id"]);
        if(!$broker->getRezultat()){
            echo "greska u bazi";
        }else{
            echo "uspesno obrisan film";
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

function validirajFilm($naziv,$kategorija,$brojMinuta){
    $naziv=trim($naziv);
    $kategorija=trim($kategorija);
    $brojMinuta=trim($brojMinuta);
    return strlen($naziv)>3 && strlen($naziv)<40 && intval($kategorija) && intval($brojMinuta);
}

?>