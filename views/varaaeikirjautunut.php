<h2>Varaa rekisteröitymättä</h2>

<form class="form-horizontal" role="form" action="varaarekisteroitymatta.php" method="post">
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
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Varaa aika</button>
        </div>
    </div>
</form>

<h2>Liity kanta-asiakkaaksi</h2>

<p>Liity kanta-asiakkaaksi <a href="liity.php">täyttämällä lomake</a></p>

<h2>Kirjaudu sisään</h2>

<p>Kirjaudu sisään <a href="javascript: document.getElementById('inputEmail1').focus();">sivuvalikosta</a></p>

