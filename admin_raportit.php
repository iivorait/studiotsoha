<?php

require_once 'libs/yleiset.php';

onkoKirjautunut(true);
tarkistaKayttooikeus(true, true);

$kuukausi = date("m");
$vuosi = date("Y");

if(isset($_POST['kuukausi'])) {
    if(!is_numeric($_POST['kuukausi'])||$_POST['kuukausi']<1||$_POST['kuukausi']>12) {
        $_SESSION['virheilmoitus'] = "Kuukausi oli väärän muotoinen.";
    } else {
        $kuukausi = $_POST['kuukausi'];
    }
    
    if(!is_numeric($_POST['vuosi'])||$_POST['vuosi']<2013||$_POST['vuosi']>3000) {
        $_SESSION['virheilmoitus'] = "Vuosi oli väärän muotoinen.";
    } else {
        $vuosi = $_POST['vuosi'];
    }
} 

$tyontekijat = Tyontekija::haeTyontekijat();

foreach ($tyontekijat as $tyontekija) {
    $varaukset = $tyontekija->haeKuukaudenVaraukset($kuukausi, $vuosi);
    
    $tyontekijanSumma = 0;
    
    foreach ($varaukset as $varaus) {
        $tyontekijanSumma += $varaus->getHinta();
    }
    
    $tyotunnit = $tyontekija->haeKuukaudenTyotunnit($kuukausi, $vuosi);
    
    $tyontekijanTunnit = 0;
    
    foreach ($tyotunnit as $tuntikirjaus) {
        $tyontekijanTunnit += $tuntikirjaus->getTuntimaara();
    }
    
    $raportit['Varauksia työntekijälle ' . $tyontekija->getNimi()] = count($varaukset) . 'kpl (yht. ' . $tyontekijanSumma . '€)';
    $raportit['Työtunteja työntekijällä ' . $tyontekija->getNimi()] = $tyontekijanTunnit . 'h';
    $varauksiaYhteensa += count($varaukset);
    $varaustenSumma += $tyontekijanSumma;
    $tyotuntejaYhteensa += $tyontekijanTunnit;
}

$raportit['Varausten yhteismäärä'] = $varauksiaYhteensa . 'kpl';
$raportit['Varausten yhteissumma'] = $varaustenSumma . '€';
$raportit['Työtuntien yhteismäärä'] = $tyotuntejaYhteensa . 'h';

naytaNakyma('admin_raportit.php', array(
    "raportit" => $raportit,
    "kuukausi" => $kuukausi,
    "vuosi" => $vuosi
));
