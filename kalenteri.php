<?php

require_once 'libs/yleiset.php';

if(!empty($_GET['palvelu'])) {
    $palvelu = Palvelu::haePalvelu($_GET['palvelu']);
} else {
    $palvelu = new Palvelu();
    $palvelu->setKesto(15);
}

if(isset($_GET['paivamaara'])) {
    if(isset($_GET['edellinen'])) {
        $paivamaara = date('Y-m-d',strtotime($_GET['paivamaara'] . ' - 1 day'));
    } elseif (isset($_GET['seuraava'])) {
        $paivamaara = date('Y-m-d',strtotime($_GET['paivamaara'] . ' + 1 day'));
    } else {
        $paivamaara = $_GET['paivamaara'];
    }
} else {
    $paivamaara = "2014-03-20"; //myöhemmin date("Y-m-d") tai date("d.m.Y")
}

$tyontekijat = Tyontekija::haePalveluntarjoajat($palvelu->getTunnus());

foreach ($tyontekijat as $tyontekija) {
    $tyontekija->lataaKalenteri($paivamaara);
}

$tyoajat = getTyoajat();

naytaNakyma('kalenteri.php', array(
    'tyontekijat' => $tyontekijat,
    'tyoajat' => $tyoajat,
    'palvelu' => $palvelu,
    'paivamaara' => $paivamaara
));