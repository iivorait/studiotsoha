<?php

require_once 'libs/yleiset.php';

if(isset($_GET['palvelu'])) {
    $palvelu_id = $_GET['palvelu'];
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

$tyontekijat = Tyontekija::haePalveluntarjoajat($palvelu_id);

foreach ($tyontekijat as $tyontekija) {
    $tyontekija->lataaKalenteri($paivamaara);
}

$tyoajat = array();

for($tunti = tyoaikaAlkaa; $tunti < tyoaikaLoppuu; $tunti++) {
    for($minuutti = 00; $minuutti < 60; $minuutti += 15) {
        $tyoajat[] = array(
            'tunti' => $tunti, 
            'minuutti' => $minuutti
        );
    }
}

naytaNakyma('kalenteri.php', array(
    'tyontekijat' => $tyontekijat,
    'tyoajat' => $tyoajat,
    'palvelu' => $palvelu_id,
    'paivamaara' => $paivamaara
));