<?php

require_once 'libs/yleiset.php';

if(!empty($_GET['palvelu'])) {
    $palvelu = Palvelu::haePalvelu($_GET['palvelu']);
} else {
    $palvelu = new Palvelu();
    $palvelu->setKesto(15);
}


if(isset($_GET['paivamaara'])) {
    $paivamaarapalaset = explode(".",$_GET['paivamaara']);
    
    if(checkdate($paivamaarapalaset[1], $paivamaarapalaset[0], $paivamaarapalaset[2])) {
        if(isset($_GET['edellinen'])) {
            $paivamaara = date('d.m.Y',strtotime($_GET['paivamaara'] . ' - 1 day'));
        } elseif (isset($_GET['seuraava'])) {
            $paivamaara = date('d.m.Y',strtotime($_GET['paivamaara'] . ' + 1 day'));
        } else {
            $paivamaara = $_GET['paivamaara'];
        }
        if(date('d.m.Y', strtotime($paivamaara)) < date('d.m.Y')) {
            $paivamaara = date('d.m.Y');
            $_SESSION['virheilmoitus'] = "Päivämäärä on jo mennyt.";
        }
    } else {
        $paivamaara = date('d.m.Y');
        $_SESSION['virheilmoitus'] = "Päivämäärä ei ollut oikeassa muodossa.";
    }
    
} else {
    $paivamaara = date("d.m.Y"); 
}

$tyontekijat = Tyontekija::haePalveluntarjoajat($palvelu->getTunnus());

foreach ($tyontekijat as $tyontekija) {
    $tyontekija->lataaKalenteri(date('Y-m-d',strtotime($paivamaara)));
}

$tyoajat = getTyoajat();

naytaNakyma('kalenteri.php', array(
    'tyontekijat' => $tyontekijat,
    'tyoajat' => $tyoajat,
    'palvelu' => $palvelu,
    'paivamaara' => $paivamaara
));