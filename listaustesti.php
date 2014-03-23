<?php
//require_once sisällyttää annetun tiedoston vain kerran
require_once "libs/tietokantayhteys.php"; 
require_once "libs/models/kayttaja.php";

//Lista asioista array-tietotyyppiin laitettuna:
$lista = Kayttaja::getKayttajat();
?>
<!DOCTYPE HTML>
<head>
    <title>Listaustesti</title>
</head>
<body>
    <h3>Asiakkaat:</h3>
    <?php
        foreach ($lista as $asiakas)
        {
            echo $asiakas->getId() . ": " . $asiakas->getTunnus() . "<br />";
        }
    ?>
</body>
</html>