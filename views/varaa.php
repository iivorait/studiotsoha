<h2>Varaa aika</h2>

<form id="lomake" class="form-horizontal" role="form" action="varaatallennus.php" method="post">
    <input type="hidden" name="kampaaja" value="<?php echo $data->tyontekija->getTunnus(); ?>" />
    <input type="hidden" name="paiva" value="<?php echo $data->paiva; ?>" />

    <table class="table table-striped">
        <tr>
            <th>Kampaaja</th>
            <td><?php echo $data->tyontekija->getNimi(); ?></td>
        </tr>
        <tr>
            <th>Päivä</th>
            <td><?php echo $data->paiva; ?></td>
        </tr>
        <tr>
            <th>Palvelu</th>
            <td>
                <select name="palvelu" class="form-control" onchange="paivita()">
                    <option value="">Valitse palvelu</option>
                    <?php

                    foreach($data->palvelut as $palvelu) {
                        echo '<option value="' . $palvelu->getTunnus() . '"';
                        
                        if($palvelu->getTunnus() == $data->valittupalvelu->getTunnus()) {
                            echo ' selected';
                        }

                        echo '>' . $palvelu->getNimi() . ' (' . $palvelu->getKesto() . ' minuuttia)</option>';
                    }

                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Ajankohta</th>
            <td>
                <?php
                if($data->valittupalvelu->getTunnus() != null) {
                ?>
                
                    <select name="aika" class="form-control">
                        <?php

                        foreach ($data->vapaatajat as $aika) {
                            echo '<option value="' . $aika['tunti'] . '.' . $aika['minuutti'] . '"';

                            if($aika['tunti'] . '.' . $aika['minuutti'] == $data->aloitusaika) {
                                echo ' selected';
                            }

                            echo '>' . $aika['tunti'] . '.' . sprintf('%02s',$aika['minuutti']) . ' - ' . $aika['loppu'] . '</option>';
                        }
                        ?>
                    </select>
                <?php } else { ?>
                <input type="hidden" name="aika" value="<?php echo htmlspecialchars($data->aloitusaika); ?>" />
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th>Toivomukset</th>
            <td>
                <textarea name="toivomukset" class="form-control" rows="3"><?php echo htmlspecialchars($data->toivomukset); ?></textarea>
            </td>
        </tr>
        <tr>
            <td> </td>
            <td>
                <button type="submit" class="btn btn-default">Varaa</button>
            </td>
        </tr>
    </table>
</form>

<script>
    function paivita() {
        document.getElementById("lomake").action = "varaa.php";
        document.getElementById("lomake").method = "get";
        document.getElementById("lomake").submit();
    }
</script>
   