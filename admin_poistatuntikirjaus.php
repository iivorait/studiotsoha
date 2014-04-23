<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

if(!isset($_GET['paiva'])) {
    header('Location: admin_tyoaikojenkirjaus.php');
    $_SESSION['virheilmoitus'] = "Päivämäärää ei ole valittu!";
    die();
}

$tuntikirjaus = Tuntikirjaus::haeTuntikirjaus(getKirjautunutKayttaja()->getTunnus(), $_GET['paiva']);
$tuntikirjaus->poistaKannasta();

header('Location: admin_tyoaikojenkirjaus.php');
$_SESSION['ilmoitus'] = "Tuntikirjaus poistettiin.";