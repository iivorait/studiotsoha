<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

//Hae kirjaukset viikon ajalta for-loopissa

//Lisää/muuta-napit
for ($i = 0; $i < 7; $i++) {
    $paivamaara = date("Y-m-d", time() - 60 * 60 * 24 * $i);
    $tuntikirjaus = Tuntikirjaus::haeTuntikirjaus(getKirjautunutKayttaja()->getTunnus(), $paivamaara);
    $paivat[] = array(
        "paivamaara" => $paivamaara,
        "tuntikirjaus" => $tuntikirjaus
    );
}


naytaNakyma('admin_tyoaikojenkirjaus.php', array(
    "paivat" => $paivat
));
