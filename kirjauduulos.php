<?php

require_once 'libs/yleiset.php';

unset($_SESSION['kirjautunut']);
unset($_SESSION['keskenerainenvaraus']);

naytaNakyma('etusivu.php');
