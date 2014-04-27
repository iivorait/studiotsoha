<h2>Tuntikirjaus</h2>

<form class="form-horizontal" role="form" action="admin_tuntikirjaustallennus.php" method="post">
    <div class="form-group">
        <label class="col-sm-2 control-label">Päivämäärä</label>
        <div class="col-md-4">
            <?php echo htmlspecialchars(date("d.m.Y", strtotime($data->tuntikirjaus->getPaivamaara()))); ?>
            <input type="hidden" name="paivamaara" value="<?php echo htmlspecialchars($data->tuntikirjaus->getPaivamaara()); ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="tuntimaara" class="col-sm-2 control-label">Tuntimäärä</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="tuntimaara" id="tuntimaara" placeholder="Tuntimäärä" value="<?php echo htmlspecialchars($data->tuntikirjaus->getTuntimaara()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="kommentti" class="col-sm-2 control-label">Kommentti</label>
        <div class="col-md-4">
            <textarea class="form-control" name="kommentti" id="kommentti"><?php echo htmlspecialchars($data->tuntikirjaus->getKommentti()); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
    </div>
</form>