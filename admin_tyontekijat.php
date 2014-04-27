<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true, true);

$tyontekijat = Tyontekija::haeTyontekijat();

naytaNakyma('admin_tyontekijat.php', array(
    "tyontekijat" => $tyontekijat
));
