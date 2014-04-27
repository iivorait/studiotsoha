<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true, true);

if(!isset($palvelu)) {
    $palvelu = Palvelu::haePalvelu($_GET['palvelu']);
}

if($palvelu==NULL) {
    $palvelu = new Palvelu();
}

naytaNakyma('admin_palvelulomake.php', array(
    'palvelu' => $palvelu
));
