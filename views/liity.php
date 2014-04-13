<h2>Liity kanta-asiakkaaksi</h2>

<form class="form-horizontal" role="form" action="liitytallennus.php" method="post">
    <div class="form-group">
        <label for="etunimi" class="col-sm-2 control-label">Etunimi</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="etunimi" id="etunimi" placeholder="Etunimi" value="<?php echo htmlspecialchars($data->asiakas->getEtunimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="sukunimi" class="col-sm-2 control-label">Sukunimi</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="sukunimi" id="sukunimi" placeholder="Sukunimi" value="<?php echo htmlspecialchars($data->asiakas->getSukunimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="lahiosoite" class="col-sm-2 control-label">Lähiosoite</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="lahiosoite" id="lahiosoite" placeholder="Lähiosoite" value="<?php echo htmlspecialchars($data->asiakas->getLahiosoite()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="postinumero" class="col-sm-2 control-label">Postinumero</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="postinumero" id="postinumero" placeholder="Postinumero" value="<?php echo htmlspecialchars($data->asiakas->getPostinumero()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="postitoimipaikka" class="col-sm-2 control-label">Postitoimipaikka</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="postitoimipaikka" id="postitoimipaikka" placeholder="Postitoimipaikka" value="<?php echo htmlspecialchars($data->asiakas->getPostitoimipaikka()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="puhelinnumero" class="col-sm-2 control-label">Puhelinnumero</label>
        <div class="col-md-4">
            <input type="number" class="form-control" name="puhelinnumero" id="puhelinnumero" placeholder="Puhelinnumero" value="<?php echo htmlspecialchars($data->asiakas->getPuhelinnumero()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="sahkopostiosoite" class="col-sm-2 control-label">Sähköpostiosoite</label>
        <div class="col-md-4">
            <input type="email" class="form-control" name="sahkopostiosoite" id="sahkopostiosoite" placeholder="Sähköpostiosoite" value="<?php echo htmlspecialchars($data->asiakas->getSahkoposti()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="salasana" class="col-sm-2 control-label">Salasana</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="salasana" id="salasana" placeholder="Salasana" value="<?php echo htmlspecialchars($data->asiakas->getSalasana()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="salasana2" class="col-sm-2 control-label">Toista salasana</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="salasana2" id="salasana2" placeholder="Toista salasana" value="<?php echo htmlspecialchars($data->asiakas->getSalasana()); ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Liity</button>
        </div>
    </div>
</form>