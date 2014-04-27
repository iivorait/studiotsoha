<?php

require_once 'libs/yleiset.php';

//Poistetaan mahdollinen keskeneräinen varaus uutta varten
unset($_SESSION['keskenerainenvaraus']);

if (!empty($_REQUEST['palvelu'])) {
    $valittupalvelu = Palvelu::haePalvelu($_REQUEST['palvelu']);

    if ($valittupalvelu == null) {
        $_SESSION['virheilmoitus'] = "Palvelua ei löytynyt";
        header('Location: palvelut.php');
    }
} else {
    $valittupalvelu = new Palvelu();
}

$paiva = $_REQUEST['paiva'];
$tyontekija = Tyontekija::haeTyontekija($_REQUEST['kampaaja']);

if ($tyontekija == null) {
    $_SESSION['virheilmoitus'] = "Kampaajaa ei löytynyt";
    header('Location: kalenteri.php');
}

$aloitusaika = $_REQUEST['aika'];
$toivomukset = $_REQUEST['toivomukset'];

$tyontekija->lataaKalenteri(date("Y-m-d", strtotime($paiva)));
$palvelut = $tyontekija->haeTarjotutPalvelut();

$vapaatajat = getTyoajat();
foreach ($vapaatajat as $avain => $aika) { //Käydään kaikki aloitusajat läpi
    $tunti = $aika['tunti'];
    $minuutti = $aika['minuutti'];
    //Tarkistetaan, että aloitusajasta alkaen on palvelun keston verran vapaata
    for($i = 0; $i < $valittupalvelu->getKesto(); $i += 15) {
        if ($tyontekija->getKalenteri()[$tunti][$minuutti] || $tunti >= tyoaikaLoppuu) {
            unset($vapaatajat[$avain]); 
            break;
        }
        $minuutti += 15;
        if($minuutti == 60) {
            $minuutti = 0;
            $tunti++;
        }
    }
    //Tallennetaan lopetusaika tulostusta varten
    if(isset($vapaatajat[$avain])) {
        $vapaatajat[$avain]['loppu'] = $tunti . '.' . sprintf('%02s',$minuutti);
    }
    
}

naytaNakyma('varaa.php', array(
    "tyontekija" => $tyontekija,
    "palvelut" => $palvelut,
    "valittupalvelu" => $valittupalvelu,
    "paiva" => $paiva,
    "aloitusaika" => $aloitusaika,
    "vapaatajat" => $vapaatajat,
    "toivomukset" => $toivomukset,
    "virhe" => $virheet
));
