<?php
  require 'src/webscraper.php';

  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(E_ALL);


  $someParam = $argv[1];
  placeholder($someParam);

  echo print_r($result);
?>
