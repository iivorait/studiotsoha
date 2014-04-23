<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
onkoKantaasiakas(true);

naytaNakyma('muokkaatietojani.php', array(
    'asiakas' => getKirjautunutKayttaja()
));
