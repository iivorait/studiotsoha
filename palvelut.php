<?php

require_once 'libs/yleiset.php';

$palvelut = Palvelu::haePalvelut();

naytaNakyma('palvelut.php', array(
    'palvelut' => $palvelut
));
