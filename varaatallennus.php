<?php

require_once 'libs/yleiset.php';

if(!isset($_SESSION['keskenerainenvaraus'])) { //tultiin varauslomakkeesta
    $varaus = new Varaus();
    $varaus->setAloitusaika($_POST['aika']);
    $palvelu = Palvelu::haePalvelu($_POST['palvelu']);
    
    if($palvelu == null) {
        $palvelu = new Palvelu();
    }
    
    $varaus->setKesto($palvelu->getKesto());
    $varaus->setPalvelu($palvelu->getNimi());
    $varaus->setPalvelutunnus($palvelu->getTunnus());
    $varaus->setPaivamaara(date('Y-m-d', strtotime($_POST['paiva'])));
    $varaus->setToivomukset($_POST['toivomukset']);
    $varaus->setTyontekija($_POST['kampaaja']);
} else {
    $varaus = $_SESSION['keskenerainenvaraus'];
    unset($_SESSION['keskenerainenvaraus']);
}


if($varaus->onkoKelvollinen()) {
    
    if(onkoTyontekija()) {
        $_SESSION['keskenerainenvaraus'] = $varaus;
        
        $kantaasiakkaat = Asiakas::haeKantaasiakkaat();
        
        naytaNakyma("admin_varaa.php", array(
            "asiakas" => new Asiakas(),
            "kantaasiakkaat" => $kantaasiakkaat
        ));
    }
    elseif(onkoKirjautunut()) {
        $varaus->setAsiakas(getKirjautunutKayttaja()->getTunnus());
    }
    else //Ei kirjautunut
    {
        $_SESSION['keskenerainenvaraus'] = $varaus;
        naytaNakyma("varaaeikirjautunut.php", array(
            "asiakas" => new Asiakas()
        ));
    }
    
    $varaus->lisaaKantaan();
    
    header('Location: varaukseni.php');
    $_SESSION['ilmoitus'] = "Varaus on tehty.";
    
} else {
    $virheet = implode("<br>", $varaus->getVirheet());
    
    include "varaa.php";
}


    

