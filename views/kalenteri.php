<h2>Kalenteri</h2>

<p>Todo: ei menneitä päiviä, päivämäärän validointi, varauksen tekeminen</p>

<div class="row">
    <form class="form-horizontal" role="form" action="kalenteri.php" method="GET">
        <input type="hidden" name="palvelu" value="<?php echo $data->palvelu; ?>" />
        <div class="col-md-2">
            <h5>Valitse päivä</h5>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="col-md-8">
                    <input type="date" class="form-control" id="pvm" name="paivamaara" value="<?php echo $data->paivamaara; ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" name="siirry" class="btn btn-default">Siirry</button>
                </div>
            </div>

        </div>
        <div class="col-md-5">
            <button type="submit" name="edellinen" class="btn btn-default">Edellinen päivä</button>
            <button type="submit" name="seuraava" class="btn btn-default">Seuraava päivä</button>
        </div>
    </form>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th><?php echo $data->paivamaara; ?></th>
            <?php
                foreach ($data->tyontekijat as $tyontekija) { ?>
                <th><?php echo $tyontekija->getNimi(); ?></th>
            <?php }
            
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        
        foreach ($data->tyoajat as $aika) {
            echo '<tr><td>' . $aika['tunti'] . ':' . sprintf('%02s',$aika['minuutti']) . '</td>';
            
            foreach ($data->tyontekijat as $tyontekija) { 
                if($tyontekija->getKalenteri()[$aika['tunti']][$aika['minuutti']]) {
                    echo '<td class="danger"></td>';
                } else {
                    echo '<td><a href="varaus.php" class="vihrea">Varaa</a></td>';
                }
            }
            
            echo '</tr>';
            
        }
        
            

        ?>

        
    </tbody>
</table>