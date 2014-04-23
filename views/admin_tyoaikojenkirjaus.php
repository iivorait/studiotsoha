<h2>Työaikojen kirjaus</h2>

<table class="table table-striped">
    <thead>
        <tr><th>Päivämäärä</th><th>Tuntimäärä</th><th> </th>
    </thead>
<?php

foreach ($data->paivat as $paiva) {
    echo '<tr><td>' . date("d.m.Y", strtotime($paiva["paivamaara"])) . '</td><td>';
    
    if($paiva["tuntikirjaus"]==null) {
        echo 'Ei kirjausta';
    } else {
        echo $paiva["tuntikirjaus"]->getTuntimaara();
    }
    
    echo '</td><td><a href="admin_tuntikirjauslomake.php?paiva=' . $paiva["paivamaara"] . '">Muuta</a>';
    
    if($paiva["tuntikirjaus"]!=null) {
        echo ' - <a href="admin_poistatuntikirjaus.php?paiva=' . $paiva["paivamaara"] . '">Poista</a>';
    }
    
    echo '</td></tr>';
}

?>

</table>