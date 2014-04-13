<?php

require_once 'libs/yleiset.php';

$asiakas = clone getKirjautunutKayttaja();
$asiakas->setEtunimi($_POST['etunimi']);
$asiakas->setSukunimi($_POST['sukunimi']);
$asiakas->setLahiosoite($_POST['lahiosoite']);
$asiakas->setPostinumero($_POST['postinumero']);
$asiakas->setPostitoimipaikka($_POST['postitoimipaikka']);
$asiakas->setPuhelinnumero($_POST['puhelinnumero']);
$asiakas->setSahkoposti($_POST['sahkopostiosoite']);

if(!empty($_POST['salasana'])) {
    $asiakas->setSalasana($_POST['salasana']);
    $asiakas->salasananTarkistus($_POST['salasana2']);
}

if($asiakas->onkoKelvollinen()) {
    $asiakas->paivitaKantaan();
    setKirjautunutKayttaja($asiakas);
    
    header('Location: muokkaatietojani.php');
    $_SESSION['ilmoitus'] = "Tietosi on tallennettu.";
    
} else {
    $virheet = implode("<br>", $asiakas->getVirheet());
    
    naytaNakyma("muokkaatietojani.php", array(
        'asiakas' => $asiakas,
        'virhe' => $virheet
    ));
}


    

