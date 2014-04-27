<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
onkoTyontekija(true);

if(onkoJohtaja()) {
    $varaukset = Varaus::haeKaikkiVaraukset();
} else {
    $varaukset = Varaus::haeTyontekijanVaraukset(getKirjautunutKayttaja());
}

$id = (int)$_GET['id'];
$peruutusoikeus = false;

foreach ($varaukset as $avain => $varaus) {
    if($varaus->getTunnus()==$id&&$varaus->voikoTyontekijaPeruuttaa()) {
        $peruutusoikeus = true;
        unset($varaukset[$avain]);
        break;
    }
}

if(!$peruutusoikeus) {
    naytaNakyma('admin_varaukset.php', array(
        'varaukset' => $varaukset,
        'virhe' => "Et voi peruuttaa tätä varausta"
    ));
}

Varaus::peruutaVaraus($id);

naytaNakyma('admin_varaukset.php', array(
    'varaukset' => $varaukset,
    'onnistui' => "Ajan peruutus onnistui"
));
