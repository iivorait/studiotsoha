<?php
  require_once 'libs/yleiset.php';
  
  onkoKirjautunut(true);
  tarkistaKayttooikeus(true);

  naytaNakyma('tyoaikojenkirjaus.php');