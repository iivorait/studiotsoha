<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

$asiakas = Asiakas::haeAsiakas($_GET['asiakas']);

if($asiakas == null) {
    $_SESSION['virheilmoitus'] = "Asiakasta ei löytynyt";
    header('Location: admin_varaukset.php');
    die();
}

naytaNakyma('admin_naytaasiakas.php', array(
    'asiakas' => $asiakas
));