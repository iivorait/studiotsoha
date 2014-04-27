<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

if(onkoJohtaja() && isset($_GET['tyontekija'])) {
    $tyontekija = Tyontekija::haeTyontekija($_GET['tyontekija']);
    
    if($tyontekija==null) {
        naytaNakyma('etusivu.php', array(
            'virhe' => "Työntekijää ei löytynyt."
        ));
    }
} elseif(onkoJohtaja() && isset($_GET['uusi'])) {
    $tyontekija = new Tyontekija();
} else {
    $tyontekija = getKirjautunutKayttaja();
}

naytaNakyma('admin_tyontekijalomake.php', array(
    "tyontekija" => $tyontekija
));