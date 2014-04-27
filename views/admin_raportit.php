<h2>Raportit</h2>

<form class="form-horizontal" role="form" action="admin_raportit.php" method="post">
    <div class="form-group">
        <label for="kuukausi" class="col-sm-2 control-label">Kuukausi</label>
        <div class="col-md-2">
            <input type="text" class="form-control" name="kuukausi" id="kuukausi" placeholder="esimerkiksi 1" value="<?php echo htmlspecialchars($data->kuukausi); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="vuosi" class="col-sm-2 control-label">Vuosi</label>
        <div class="col-md-2">
            <input type="text" class="form-control" name="vuosi" id="vuosi" placeholder="esimerkiksi 2014" value="<?php echo htmlspecialchars($data->vuosi); ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Hae</button>
        </div>
    </div>
</form>

<table class="table table-striped">

<?php

foreach ($data->raportit as $otsikko => $arvo) {
    echo '<tr><th>' . $otsikko . '</th><td>' . $arvo . '</td></tr>';
}

?>

</table>