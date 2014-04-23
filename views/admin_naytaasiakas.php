<h2>Asiakkaan tiedot</h2>

<table class="table table-bordered">
    <tr><th>Nimi</th><td><?php echo $data->asiakas->getEtunimi() . " " . $data->asiakas->getSukunimi(); ?></td></tr>
    <tr><th>Kanta-asiakas</th><td>
        <?php
            if($data->asiakas->getKantaasiakas()) {
                echo "kyllä";
            } else {
                echo "ei";
            }
        ?>
    </td></tr>
    <tr><th>Sähköposti</th><td><a href="mailto:<?php echo $data->asiakas->getSahkoposti(); ?>"><?php echo $data->asiakas->getSahkoposti(); ?></a></td></tr>
    <tr><th>Puhelinnumero</th><td><?php echo $data->asiakas->getPuhelinnumero(); ?></td></tr>
    <tr><th>Lähiosoite</th><td><?php echo $data->asiakas->getLahiosoite(); ?></td></tr>
    <tr><th>Postinumero</th><td><?php echo $data->asiakas->getPostinumero(); ?></td></tr>
    <tr><th>Postitoimipaikka</th><td><?php echo $data->asiakas->getPostitoimipaikka(); ?></td></tr>
</table>

<a href="admin_varaukset.php">Palaa varauksiin</a>
