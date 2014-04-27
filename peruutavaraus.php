<?php

require_once 'libs/yleiset.php';

if(isset($_GET['varaus'])) { //sähköpostin peruutuslinkki
    $varaus = Varaus::haeVaraus((int)$_GET['varaus']);
    
    if($varaus==null) {
        $_SESSION['virheilmoitus'] = "Varausta ei löytynyt.";
        header("Location: etusivu.php");
        die();
    }
    
    $salasana = md5($varaus->getTunnus() . $varaus->getPaivamaara() . $varaus->getToivomukset() . "323232spurspar");
    
    if($salasana == $_GET['salasana'] && $varaus->voikoPeruuttaa()) {
        Varaus::peruutaVaraus($varaus->getTunnus());
        $_SESSION['ilmoitus'] = "Varauksesi on peruutettu.";
        header("Location: etusivu.php");
        die();
    } else {
        $_SESSION['virheilmoitus'] = "Varausta ei voida peruuttaa - joko salasana oli väärin tai varaus on jo mennyt.";
        header("Location: etusivu.php");
        die();
    }
}

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
