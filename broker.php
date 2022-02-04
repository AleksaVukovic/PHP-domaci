<?php


class Broker{

    private $rezultat;
    private $mysqli;
    private static $broker;
    public function getRezultat(){
        return $this->rezultat;
    }
    public function getMysqli(){
        return $this->mysqli;
    }
    private function __construct(){
        $this->mysqli = new mysqli("localhost", "root", "", "baza_bioskop");
        $this->mysqli->set_charset("utf8");
    }

    public static function getBroker(){
        if(!isset($broker)){
            $broker=new Broker();
        }
        return $broker;
    }
    private function izvrsiUpit($upit){
        $this->rezultat=$this->mysqli->query($upit);
    }
    public function vratiSveFilmove(){
        $this->izvrsiUpit("select k.*, kat.naziv as 'kategorija', kat.id as 'kat_id' from film k inner join kategorija_filma kat on (kat.id=k.kategorija)");
    }

    public function vratiSveFilmoveIzBioskopa($bioskop){
        $this->izvrsiUpit("select k.*, kat.naziv as 'kategorija', kat.id as 'kat_id', bk.broj_projekcija as 'brojProjekcija' from film k inner join kategorija_filma kat on (kat.id=k.kategorija) inner join bioskop_film bk on (bk.film=k.id) where bk.bioskop=".$bioskop);
    }
    public function vratiSveKategorije(){
        $this->izvrsiUpit("select * from kategorija_filma");
    }
    public function dodajFilm($naziv,$kat,$brojM){
        $this->izvrsiUpit("insert into film (naziv,kategorija,broj_minuta) values ('".$naziv."',".$kat.", ".$brojM.")");
    }
    public function obrisiFilm($id){
        $this->izvrsiUpit("delete from film where id=".$id);
    }
    public function izmeniFilm($id,$naziv,$kat,$brojM){
        $this->izvrsiUpit("update film set naziv='".$naziv."', kategorija=".$kat.", broj_minuta=".$brojM." where id=".$id);
    }
    public function vratiBioskope(){
        $this->izvrsiUpit("select * from bioskop");
    }
    public function dodajBioskop($naziv,$adresa){
        $this->izvrsiUpit("insert into bioskop(naziv,adresa) values ('".$naziv."','".$adresa."')");
    }
    public function obrisiBioskop($id){
        $this->izvrsiUpit("delete from bioskop where id=".$id);
    }
    public function dodajVezu($b,$k,$bp){
        $this->izvrsiUpit("insert into bioskop_film values (".$b.",".$k.",".$bp.")");
    }
    public function obrisiVezu($b,$k){
        $this->izvrsiUpit("delete from bioskop_film where bioskop=".$b." and film=".$k);
    }
    public function izmeniBioskop($id,$n,$a){
        $this->izvrsiUpit("update bioskop set naziv='".$n."', adresa='".$a."' where id=".$id);
    }
}

?>