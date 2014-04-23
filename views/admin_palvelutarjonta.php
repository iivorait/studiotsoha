<h2>Tarjotut palvelut</h2>

<table class="table table-striped">
    <thead>
    <th>Palvelu</th><th>Tilasi</th><th> </th>
    </thead>
    <tbody>


<?php

foreach ($data->palvelut as $palvelu) {
    echo '<tr><td>' . $palvelu["palvelu"]->getNimi() . '</td><td>';
    if($palvelu['tarjoaako']) {
        echo 'Tarjoat palvelua</td><td>'
        . '<a href="admin_muutapalveluntarjontaa.php?palvelu=' . $palvelu["palvelu"]->getTunnus() . '&amp;lopeta">Lopeta tarjoaminen</a>';
    } else {
        echo 'Et tarjoa palvelua</td><td>'
        . '<a href="admin_muutapalveluntarjontaa.php?palvelu=' . $palvelu["palvelu"]->getTunnus() . '&amp;aloita">Aloita tarjoaminen</a>';
    }
    echo '</td></tr>';
}

?>
    </tbody>
</table>

    