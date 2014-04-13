<?php

require_once 'libs/yleiset.php';

$asiakas = new Asiakas();
$asiakas->setEtunimi($_POST['etunimi']);
$asiakas->setSukunimi($_POST['sukunimi']);
$asiakas->setLahiosoite($_POST['lahiosoite']);
$asiakas->setPostinumero($_POST['postinumero']);
$asiakas->setPostitoimipaikka($_POST['postitoimipaikka']);
$asiakas->setPuhelinnumero($_POST['puhelinnumero']);
$asiakas->setSahkoposti($_POST['sahkopostiosoite']);
$asiakas->setSalasana($_POST['salasana']);
$asiakas->salasananTarkistus($_POST['salasana2']);

if($asiakas->onkoKelvollinen()) {
    $asiakas->lisaaKantaan();
    
    $kayttaja = Asiakas::etsiKayttajaTunnuksilla($_POST['sahkopostiosoite'], $_POST['salasana']);

    $_SESSION['kirjautunut'] = $kayttaja;
    
    header('Location: etusivu.php');
    $_SESSION['ilmoitus'] = "Tervetuloa kanta-asiakkaaksi!";
    
} else {
    $virheet = implode("<br>", $asiakas->getVirheet());
    
    naytaNakyma("liity.php", array(
        'asiakas' => $asiakas,
        'virhe' => $virheet
    ));
}


    

