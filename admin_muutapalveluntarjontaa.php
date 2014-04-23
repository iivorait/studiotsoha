<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

if(isset($_GET['aloita'])) {
    $kysely = Palveluntarjoaja::lisaaPalveluntarjoaja($_GET['palvelu'], getKirjautunutKayttaja()->getTunnus());
} else if(isset($_GET['lopeta'])) {
    $kysely = Palveluntarjoaja::poistaPalveluntarjoaja($_GET['palvelu'], getKirjautunutKayttaja()->getTunnus());
}

if(!$kysely) {
    $_SESSION['virheilmoitus'] = "Muutoksessa tapahtui virhe - saatat jo tarjota palvelua";
    header('Location: admin_palvelutarjonta.php');
} else {
    $_SESSION['ilmoitus'] = "Palvelun tilaa on muutettu";
    header('Location: admin_palvelutarjonta.php');
}
