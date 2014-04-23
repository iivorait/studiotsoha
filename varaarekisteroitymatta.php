<?php

require_once 'libs/yleiset.php';

if(!isset($asiakas)) {
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

if($asiakas->onkoKelvollinen()) {
    $asiakas->lisaaKantaan();
    
    $asiakas->haeTunnus();

    $_SESSION['kirjautunut'] = $asiakas;
    
    header('Location: varaatallennus.php');

    
} else {
    $virheet = implode("<br>", $asiakas->getVirheet());
    
    naytaNakyma('varaaeikirjautunut.php', array(
        'asiakas' => $asiakas,
        'virhe' => $virheet
    ));
}

