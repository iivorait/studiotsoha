<!DOCTYPE html>
<html>
    <head>
        <title>Studio TsoHa</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div id="otsikko" class="row">
                <div class="col-md-3">Studio TsoHa</div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="etusivu.php">Etusivu</a></li>
                            <li><a href="palvelut.php">Palvelut</a></li>
                            <li><a href="kalenteri.php">Kalenteri</a></li>
                            <li><a href="tiedot.php">Yrityksen tiedot</a></li>
                            <?php if(!onkoKirjautunut()) { //kirjautuneille ei näytetä kanta-asiakaslomaketta ?>
                                <li><a href="liity.php">Liity kanta-asiakkaaksi</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                    //Kirjautumisikkuna
                    if(!onkoKirjautunut()) { ?>
                    
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Kirjaudu sisään
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" action="kirjaudu.php" method="POST">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" id="inputEmail1" name="email" placeholder="Sähköpostiosoite" value="<?php echo $data->kayttaja; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="Salasana">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <button type="submit" class="btn btn-default">Kirjaudu</button>
                                        </div>
                                    </div>
                                </form>

                                <?php if (!empty($data->kirjautumisvirhe)) { ?>
                                    <div class="alert alert-danger"><?php echo $data->kirjautumisvirhe; ?></div>
                                <?php } ?>

                            </div>
                        </div>
                    <?php } //Kirjautumisikkuna
                   
                    //Työntekijä-valikko
                    elseif(onkoTyontekija()) {  ?>
                        <div class="panel panel-default">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="admin_varaukset.php">Varaukset</a></li>
                                <li><a href="admin_tyoaikojenkirjaus.php">Työaikojen kirjaus</a></li>
                                <li><a href="admin_palvelutarjonta.php">Palvelutarjonta</a></li>
                                <?php if(onkoJohtaja()) { ?>
                                    <li><a href="tyontekijat.php">Työntekijät</a></li>
                                    <li><a href="raportit.php">Raportit</a></li>
                                <?php } ?>
                                <li><a href="kirjauduulos.php">Kirjaudu ulos</a></li>
                            </ul>
                        </div>
                    <?php } //Työntekijä-valikko
                   
                    //Asiakasvalikko
                    else {  ?>
                        <div class="panel panel-default">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="varaukseni.php">Varaukseni</a></li>
                                <?php if(onkoKantaasiakas()) { //vain kanta-asiakkaat voivat muokata tietojaan ?>
                                    <li><a href="muokkaatietojani.php">Muokkaa tietojani</a></li>
                                <?php } ?>
                                <li><a href="kirjauduulos.php">Kirjaudu ulos</a></li>
                            </ul>
                        </div>
                    <?php  } //Asiakasvalikko ?>
                </div>
                <div class="col-md-9">
                    
                    <?php 
                    if (!empty($data->virhe)) { 
                        echo '<div class="alert alert-danger">' . $data->virhe . '</div>';
                    }
                    
                    if (!empty($_SESSION['virheilmoitus'])) { 
                        echo '<div class="alert alert-danger">' . $_SESSION['virheilmoitus'] . '</div>';
                        unset($_SESSION['virheilmoitus']);
                    }
                    
                    if (!empty($_SESSION['ilmoitus'])) { 
                        echo '<div class="alert alert-success">' . $_SESSION['ilmoitus'] . '</div>';
                        unset($_SESSION['ilmoitus']);
                    }
                    
                    if (!empty($data->onnistui)) { 
                        echo '<div class="alert alert-success">' . $data->onnistui . '</div>';
                    }
                    
                    require 'views/' . $sivu; ?>
                    
                </div>
            </div>
        </div>
    </body>
</html>
