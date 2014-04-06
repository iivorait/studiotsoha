<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);

$varaukset = Varaus::haeAsiakkaanVaraukset(getKirjautunutKayttaja());

naytaNakyma('varaukseni.php', array(
    'varaukset' => $varaukset
));
