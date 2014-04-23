<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

if(!isset($_GET['paiva'])) {
    header('Location: admin_tyoaikojenkirjaus.php');
    $_SESSION['virheilmoitus'] = "Päivämäärää ei ole valittu!";
    die();
}

if(!isset($tuntikirjaus)) {
    $tuntikirjaus = Tuntikirjaus::haeTuntikirjaus(getKirjautunutKayttaja()->getTunnus(), $_GET['paiva']);
    
    if($tuntikirjaus == null) {
        $tuntikirjaus = new Tuntikirjaus();
        $tuntikirjaus->setPaivamaara($_GET['paiva']);
        $tuntikirjaus->setTyontekija(getKirjautunutKayttaja());
    }
}

naytaNakyma('admin_tuntikirjauslomake.php', array(
    "tuntikirjaus" => $tuntikirjaus
));
