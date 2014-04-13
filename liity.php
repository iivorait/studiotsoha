<?php

require_once 'libs/yleiset.php';

if(onkoKirjautunut()) {
    naytaNakyma('etusivu.php', array(
    'virhe' => "Olet jo kanta-asiakas"
));
}

if(!isset($asiakas)) {
    $asiakas = new Asiakas();
}

naytaNakyma('liity.php', array(
    'asiakas' => $asiakas
));
