<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

$palvelut = Palvelu::haePalvelut();

$tarjoaa = array();

foreach ($palvelut as $palvelu) {
    $tarjoaa[] = array(
        "palvelu" => $palvelu, 
        "tarjoaako" => Palveluntarjoaja::tarjoaakoTyontekija(getKirjautunutKayttaja()->getTunnus(), $palvelu->getTunnus())
    );
}

naytaNakyma('admin_palvelutarjonta.php', array(
    'palvelut' => $tarjoaa
));