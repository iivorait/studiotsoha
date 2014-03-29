<?php
  require_once 'libs/yleiset.php';
  
  onkoKirjautunut(true);
  tarkistaKayttooikeus(true);

  naytaNakyma('varaukset.php');