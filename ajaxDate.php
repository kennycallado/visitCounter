<?php

require_once("autoloader.php");

$data = new DataShow();

$year  = (isset($_GET["year"]))  ? $_GET["year"]  : NULL;
$month = (isset($_GET["month"])) ? $_GET["month"] : NULL;

if ($year) {
  // Esto quizá se podría optimizar.
  $meses = [ "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre", ];

  $response = [
    "enero"       => 0,
    "febrero"     => 0,
    "marzo"       => 0,
    "abril"       => 0,
    "mayo"        => 0,
    "junio"       => 0,
    "julio"       => 0,
    "agosto"      => 0,
    "septiembre"  => 0,
    "octubre"     => 0,
    "noviembre"   => 0,
    "diciembre"   => 0,
  ];

  $info = $data->showByYear($year);

  foreach (array_keys($info) as $month) {
    $response[$meses[$month -1]] = $info[$month];
  }

  echo json_encode($response);
} elseif ($month) {
  $response = [];

  $info = $data->showByMonth($month);

  $response = $info; 

  echo json_encode($response);
} else { echo "Error"; }

