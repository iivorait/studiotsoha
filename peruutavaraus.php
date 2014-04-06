<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);

$varaukset = Varaus::haeAsiakkaanVaraukset(getKirjautunutKayttaja());

$id = (int)$_GET['id'];
$peruutusoikeus = false;

foreach ($varaukset as $avain => $varaus) {
    if($varaus->getTunnus()==$id&&$varaus->voikoPeruuttaa()) {
        $peruutusoikeus = true;
        unset($varaukset[$avain]);
        break;
    }
}

if(!$peruutusoikeus) {
    naytaNakyma('varaukseni.php', array(
        'varaukset' => $varaukset,
        'virhe' => "Et voi peruuttaa tätä varausta"
    ));
}

Varaus::peruutaVaraus($id);

naytaNakyma('varaukseni.php', array(
    'varaukset' => $varaukset,
    'onnistui' => "Ajan peruutus onnistui"
));
