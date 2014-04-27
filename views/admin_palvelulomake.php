<?php

    if($data->palvelu->getTunnus() == "") { ?>
        <h2>Uusi palvelu</h2>
    <?php } else { ?>
        <h2>Muokkaa palvelua</h2>
    <?php
    }
?>

<form class="form-horizontal" role="form" action="admin_palvelutallennus.php" method="post">
    <input type="hidden" name="tunnus" value="<?php echo $data->palvelu->getTunnus(); ?>" />
    <div class="form-group">
        <label for="nimi" class="col-sm-2 control-label">Nimi</label>
        <div class="col-md-4">
            <input type="text" class="form-control" id="nimi" name="nimi" placeholder="Nimi" value="<?php echo htmlspecialchars($data->palvelu->getNimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="hinta" class="col-sm-2 control-label">Hinta</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="hinta" name="hinta" placeholder="Hinta" value="<?php echo htmlspecialchars($data->palvelu->getHinta()); ?>">
        </div>
        €
    </div>
    <div class="form-group">
        <label for="kesto" class="col-sm-2 control-label">Kesto</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="kesto" name="kesto" placeholder="Kesto" value="<?php echo htmlspecialchars($data->palvelu->getKesto()); ?>">
        </div>
        minuuttia
    </div>
    <div class="form-group">
        <label for="kuvaus" class="col-sm-2 control-label">Kuvaus</label>
        <div class="col-md-6">
            <textarea class="form-control" id="kuvaus" name="kuvaus" rows="5"><?php echo htmlspecialchars($data->palvelu->getKuvaus()); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
    </div>
</form>