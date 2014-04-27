<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true);

if(!onkoJohtaja()) { //tavalliset työntekijät muokkaavat vain omia tietojaan
    $tyontekija = getKirjautunutKayttaja();
} else {
    $tyontekija = Tyontekija::haeTyontekija($_POST['tunnus']);
    
    if($tyontekija==null) {
        $tyontekija = new Tyontekija();
    }
    
    $tyontekija->setJohtaja($_POST['johtaja']);
}

$tyontekija->setNimi($_POST['nimi']);
$tyontekija->setSahkoposti($_POST['sahkoposti']);
$tyontekija->setTunnus($_POST['tunnus']);
$tyontekija->setKuvaus($_POST['kuvaus']);

if(!empty($_POST['salasana'])) {
    $tyontekija->setSalasana($_POST['salasana']);
    $tyontekija->salasananTarkistus($_POST['salasana2']);
}

if($tyontekija->onkoKelvollinen()) {

    if($tyontekija->getTunnus()!="") {
        $tyontekija->paivitaKantaan();
    } else {
        $tyontekija->lisaaKantaan();
    }
    
    if (!empty($_FILES["kuva"]["name"])) {
        if (file_exists("images/" . $tyontekija->getTunnus() . ".jpg")) {
            unlink("images/" . $tyontekija->getTunnus() . ".jpg");
        }
        move_uploaded_file($_FILES["kuva"]["tmp_name"], "images/" . $tyontekija->getTunnus() . ".jpg");
    }

    if(onkoJohtaja()) {
        header('Location: admin_tyontekijat.php');
    } else {
        header('Location: admin_tyontekijalomake.php');
    }
    
    $_SESSION['ilmoitus'] = "Tiedot tallennettiin.";
    
} else {
    $virheet = implode("<br>", $tyontekija->getVirheet());
    
    naytaNakyma("admin_tyontekijalomake.php", array(
        'tyontekija' => $tyontekija,
        'virhe' => $virheet
    ));
}



