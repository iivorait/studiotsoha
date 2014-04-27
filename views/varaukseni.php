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
                        <td><?php echo date("d.m.Y", strtotime($varaus->getPaivamaara())); ?></td>
                        <td><?php echo $varaus->getAjankohta(); ?></td>
                        <td><?php echo $varaus->getTyontekija()->getNimi(); ?></td>
                        <td><?php echo $varaus->getPalvelu(); ?></td>
                        <td>
                            <?php if($varaus->voikoPeruuttaa()) { ?>
                                <a href="peruutavaraus.php?id=<?php echo $varaus->getTunnus(); ?>" class="punainen"
                                   onclick="return confirm('Haluatko varmasti peruuttaa varauksen?')">peruuta varaus</a>
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

if(!$data->naytavanhat) { ?>
    <p><a href="varaukseni.php?naytakaikki">Näytä myös vanhemmat varaukset</a>
<?php 
}