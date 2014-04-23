<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

$tuntikirjaus = new Tuntikirjaus();
$tuntikirjaus->setKommentti($_POST['kommentti']);
$tuntikirjaus->setPaivamaara($_POST['paivamaara']);
$tuntikirjaus->setTuntimaara($_POST['tuntimaara']);
$tuntikirjaus->setTyontekija(getKirjautunutKayttaja());

if($tuntikirjaus->onkoKelvollinen()) {
    $tuntikirjaus->ylikirjoitaKantaan();

    header('Location: admin_tyoaikojenkirjaus.php');
    $_SESSION['ilmoitus'] = "Työtunnit kirjattiin.";
    
    
} else {
    $virheet = implode("<br>", $tuntikirjaus->getVirheet());
    
    naytaNakyma("admin_tuntikirjauslomake.php", array(
        'tuntikirjaus' => $tuntikirjaus,
        'virhe' => $virheet
    ));
}



