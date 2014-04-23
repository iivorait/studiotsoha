<?php

require_once 'libs/yleiset.php';

$tyontekijat = Tyontekija::haeTyontekijat();

naytaNakyma('tiedot.php', array(
    "tyontekijat" => $tyontekijat
));
