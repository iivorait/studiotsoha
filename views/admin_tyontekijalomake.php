<h2>Työntekijän tiedot</h2>

<form class="form-horizontal" role="form" action="admin_tyontekijatallennus.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tunnus" value="<?php echo $data->tyontekija->getTunnus(); ?>" />
    <div class="form-group">
        <label for="nimi" class="col-sm-2 control-label">Nimi</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="nimi" id="nimi" placeholder="Nimi" value="<?php echo htmlspecialchars($data->tyontekija->getNimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="sahkoposti" class="col-sm-2 control-label">Sähköposti</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="sahkoposti" id="sahkoposti" placeholder="Sähköposti" value="<?php echo htmlspecialchars($data->tyontekija->getSahkoposti()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="kuvaus" class="col-sm-2 control-label">Kuvaus</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="kuvaus" id="kuvaus" placeholder="Kuvaus" value="<?php echo htmlspecialchars($data->tyontekija->getKuvaus()); ?>">
        </div>
    </div>
    <?php if(onkoJohtaja()) { ?>
    <div class="form-group">
        <label for="johtaja" class="col-sm-2 control-label">Johtaja</label>
        <div class="col-md-4">
            <select class="form-control" name="johtaja" id="johtaja">
                <option value="0" <?php if(!$data->tyontekija->getJohtaja()) { echo 'selected="selected"'; } ?>>Ei</option>
                <option value="1" <?php if($data->tyontekija->getJohtaja()) { echo 'selected="selected"'; } ?>>Kyllä</option>
            </select>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <div class="col-md-6">
            Jätä kuvakenttä tyhjäksi, jos et halua muuttaa kuvaa.
        </div>
    </div>
    <div class="form-group">
        <label for="kuva" class="col-sm-2 control-label">Kuvatiedosto</label>
        <div class="col-md-4">
            <input type="file" class="form-control" name="kuva" id="kuva">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            Jätä salasanakentät tyhjäksi, jos et halua muuttaa salasanaa.
        </div>
    </div>
    <div class="form-group">
        <label for="salasana" class="col-sm-2 control-label">Salasana</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="salasana" id="salasana" placeholder="Salasana">
        </div>
    </div>
    <div class="form-group">
        <label for="salasana2" class="col-sm-2 control-label">Toista salasana</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="salasana2" id="salasana2" placeholder="Toista salasana">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
    </div>
</form>