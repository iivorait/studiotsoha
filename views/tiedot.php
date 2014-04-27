<h2>Yrityksen tiedot</h2>

<p>
    <b>Oy Studio TsoHa Ltd Ab HD-DVD</b><br />
    Spurdospärdentie 1337<br />
    09001 HAXBÖLE
</p>

<iframe width="390" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fi/maps?q=Hakkila, Vantaa&amp;output=embed&amp;iwloc=near"></iframe>


<hr />

<h3>Kampaajat</h3>

<div class="row">

<?php

$luku = 0;

foreach ($data->tyontekijat as $tyontekija) { 
    ?>
    <div class="col-md-3">
        <img height="150" src="images/<?php echo $tyontekija->getTunnus(); ?>.jpg" alt="" /> <br />
        <b><?php echo $tyontekija->getNimi(); ?></b><br />
        <?php echo $tyontekija->getKuvaus(); ?>
    </div>
    
    <?php 

    $luku++;

    if($luku == 3) {
        echo '</div><div class="row">';
        $luku = 0;
    }

}

?>

</div>