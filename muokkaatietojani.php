<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);

naytaNakyma('muokkaatietojani.php', array(
    'asiakas' => getKirjautunutKayttaja()
));
