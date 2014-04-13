<?php

require_once 'libs/yleiset.php';

$varaus = new Varaus();
$varaus->setAloitusaika($_POST['aika']);

$palvelu = Palvelu::haePalvelu($_POST['palvelu']);

if($palvelu == null) {
    $palvelu = new Palvelu();
}

$varaus->setKesto($palvelu->getKesto());
$varaus->setPalvelu($palvelu->getNimi());
$varaus->setPalvelutunnus($palvelu->getTunnus());
$varaus->setPaivamaara($_POST['paiva']);
$varaus->setToivomukset($_POST['toivomukset']);

$varaus->setTyontekija($_POST['kampaaja']);

if(onkoKirjautunut()) {
    $varaus->setAsiakas(getKirjautunutKayttaja()->getTunnus());
}
else //Ei kirjautunut
{
    $_SESSION['virheilmoitus'] = "Kirjautumatta varaamista ei vielä toteutettu";
    header('Location: etusivu.php');
}

if($varaus->onkoKelvollinen()) {
    $varaus->lisaaKantaan();
    
    header('Location: varaukseni.php');
    $_SESSION['ilmoitus'] = "Varaus on tehty.";
    
} else {
    $virheet = implode("<br>", $varaus->getVirheet());
    
    
    
    include "varaa.php";
}


    

