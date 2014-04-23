<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

if($_POST['asiakas']!=0) {
    $asiakas = Asiakas::haeAsiakas($_POST['asiakas']);
} else {
    $salasana = mt_rand(1000000,999999999);
    
    $asiakas = new Asiakas();
    $asiakas->setKantaasiakas(false);
    $asiakas->setEtunimi($_POST['etunimi']);
    $asiakas->setSukunimi($_POST['sukunimi']);
    $asiakas->setPuhelinnumero($_POST['puhelinnumero']);
    $asiakas->setSahkoposti($_POST['sahkopostiosoite']);
    $asiakas->setSahkoposti($_POST['sahkopostiosoite']); //toinen kerta ei valita samasta sähköpostiosoitteesta
    $asiakas->setSalasana($salasana);
    $asiakas->salasananTarkistus($salasana);
}


if($asiakas->onkoKelvollinen()||$asiakas->getTunnus()!="") {
    $asiakas->lisaaKantaan();
    
    $asiakas->haeTunnus();

    $varaus = $_SESSION['keskenerainenvaraus'];
    unset($_SESSION['keskenerainenvaraus']);
    
    $varaus->setAsiakas($asiakas->getTunnus());
    
    $varaus->lisaaKantaan();
    
    header('Location: admin_varaukset.php');
    $_SESSION['ilmoitus'] = "Varaus on tehty.";
    

    
} else {
    $virheet = implode("<br>", $asiakas->getVirheet());
    
    $kantaasiakkaat = Asiakas::haeKantaasiakkaat();
    
    naytaNakyma('admin_varaa.php', array(
        'asiakas' => $asiakas,
        'virhe' => $virheet,
        "kantaasiakkaat" => $kantaasiakkaat
    ));
}