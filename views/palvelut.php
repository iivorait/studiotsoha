<h2>Palvelut</h2>

<?php if(onkoKirjautunut() && tarkistaKayttooikeus(false, true)) { ?>
    <p><a href="palvelulomake.php">Lisää palvelu</a></p>
<?php } ?>

<?php foreach ($data->palvelut as $palvelu) { ?>

    <h3><?php echo htmlspecialchars($palvelu->getNimi()); ?></h3>
    <p><?php echo htmlspecialchars($palvelu->getKuvaus()); ?></p>
    <p>
        Hinta: <?php echo htmlspecialchars($palvelu->getHinta()); ?>€ -
        Kesto: <?php echo htmlspecialchars($palvelu->getKesto()); ?> minuuttia - 
        <a href="kalenteri.php?palvelu=<?php echo $palvelu->getTunnus(); ?>">Varaa aika</a>
        <?php if(onkoKirjautunut() && tarkistaKayttooikeus(false, true)) { ?>
            - <a href="palvelulomake.php?palvelu=<?php echo $palvelu->getTunnus(); ?>">Muokkaa</a>
            - <a href="palvelupoisto.php?palvelu=<?php echo $palvelu->getTunnus(); ?>" 
                 onclick="return confirm('Haluatko varmasti poistaa <?php echo $palvelu->getNimi(); ?> -palvelun?')">Poista</a>
        <?php } ?>
    </p>
    <hr />
    <?php
}
?>