<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true, true);

if(!empty($_POST['tunnus'])) {
    $palvelu = Palvelu::haePalvelu($_POST['tunnus']);
    
} else {
    $palvelu = new Palvelu();
}

$palvelu->setHinta(str_replace(",", ".", $_POST['hinta']));
$palvelu->setKesto($_POST['kesto']);
$palvelu->setKuvaus($_POST['kuvaus']);
$palvelu->setNimi($_POST['nimi']);

if($palvelu->onkoKelvollinen()) {
    if($palvelu->getTunnus() != "") {
        $palvelu->paivitaKantaan();   
    } else {
        $palvelu->lisaaKantaan();
    }
    header('Location: palvelut.php');
    $_SESSION['ilmoitus'] = "Palvelu tallennettiin";
    
} else {
    $virheet = implode("<br>", $palvelu->getVirheet());
    
    naytaNakyma("palvelulomake.php", array(
        'palvelu' => $palvelu,
        'virhe' => $virheet
    ));
}


    

