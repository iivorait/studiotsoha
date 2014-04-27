<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true, true);

Tyontekija::poistaTyontekija($_GET['tyontekija']);

$_SESSION['ilmoitus'] = "Työntekijä poistettiin.";
header('Location: admin_tyontekijat.php');