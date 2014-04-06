<h2>Varaukseni</h2>

<?php
if (empty($data->varaukset)) {
    echo '<p>Sinulla ei ole yhtään varauksia.</p>';
} else {
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Päivämäärä</th>
                    <th>Ajankohta</th>
                    <th>Kampaaja</th>
                    <th>Palvelu</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->varaukset as $varaus) { ?>
                    <tr>
                        <td><?php echo $varaus->getPaivamaara(); ?></td>
                        <td><?php echo $varaus->getAjankohta(); ?></td>
                        <td><?php echo $varaus->getTyontekija(); ?></td>
                        <td><?php echo $varaus->getPalvelu(); ?></td>
                        <td>
                            <?php if($varaus->voikoPeruuttaa()) { ?>
                                <a href="peruutavaraus.php?id=<?php echo $varaus->getTunnus(); ?>" class="punainen">peruuta varaus</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php
} 
?>

<p><a href="#">Näytä vanhemmat varaukset</a>