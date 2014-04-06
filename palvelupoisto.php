<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true, true);

$palvelu_id = $_GET['palvelu'];

if(is_numeric($palvelu_id)) {
    Palvelu::poistaPalvelu($palvelu_id);
    $_SESSION['ilmoitus'] = "Palvelu poistettiin";
} else {
    $_SESSION['ilmoitus'] = "Palvelua ei määritetty";
}

header('Location: palvelut.php');