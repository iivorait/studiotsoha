<h2>Varaukset</h2>

<?php
if (empty($data->varaukset)) {
    echo '<p>Sinulla ei ole yhtään varauksia.</p>';
} else {    
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Päivämäärä</th>
                    <th>Ajankohta</th>
                    <th>Kampaaja</th>
                    <th>Asiakas</th>
                    <th>Palvelu</th>
                    <th>Toiveet</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->varaukset as $varaus) { ?>
                    <tr>
                        <td><?php echo date("d.m.Y", strtotime($varaus->getPaivamaara())); ?></td>
                        <td><?php echo $varaus->getAjankohta(); ?></td>
                        <td><?php echo $varaus->getTyontekija()->getNimi(); ?></td>
                        <td>
                            <a href="admin_naytaasiakas.php?asiakas=<?php echo $varaus->getAsiakas()->getTunnus(); ?>">
                                <?php echo $varaus->getAsiakas()->getEtunimi() . " " . $varaus->getAsiakas()->getSukunimi(); ?>
                            </a>
                        </td>
                        <td><?php echo $varaus->getPalvelu(); ?></td>
                        <td>
                            <?php if($varaus->getToivomukset()!="") { ?>
                                <a href="javascript:nayta('toive<?php echo $varaus->getTunnus(); ?>')">Näytä</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($varaus->voikoTyontekijaPeruuttaa()) { ?>
                                <a href="admin_peruutavaraus.php?id=<?php echo $varaus->getTunnus(); ?>" class="punainen">peruuta varaus</a>
                            <?php } ?>
                        </td>
                    </tr>
                    
                    <?php if($varaus->getToivomukset()!="") { ?>
                    <tr id="toive<?php echo $varaus->getTunnus();?>" class="piilotettu"><td> </td><th>Toiveet</th>
                        <td colspan="5"><?php echo $varaus->getToivomukset(); ?></td></tr>
                    <?php } ?>
                    
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php
} 

if(!$data->naytavanhat) { ?>
    <p><a href="admin_varaukset.php?naytakaikki">Näytä myös vanhemmat varaukset</a>
<?php 
}

?>
        
<script>

function nayta(tunnus) {
    if(document.getElementById(tunnus).className == "piilotettu") {
        document.getElementById(tunnus).className = "nakyva";
    } else {
        document.getElementById(tunnus).className = "piilotettu";
    }
}

</script>