<h2>Työntekijät</h2>


<table class="table table-striped">
    <thead>
        <tr><th>Työntekijä</th><th> </th><th> </th>
    </thead>
    
<?php

foreach ($data->tyontekijat as $tyontekija) {
    echo '<tr><td>' . $tyontekija->getNimi() . '</td><td>';
    echo '<a href="admin_tyontekijalomake.php?tyontekija=' . $tyontekija->getTunnus() . '">Muokkaa</a></td>';
    echo '<td><a href="admin_poistatyontekija.php?tyontekija=' . $tyontekija->getTunnus() . '"" '
            . 'onclick="return confirm(\'Haluatko varmasti poistaa käyttäjän?\')" class="punainen">Poista</td></tr>';
}

?>

</table>

<a href="admin_tyontekijalomake.php?uusi">Lisää uusi työntekijä</a>