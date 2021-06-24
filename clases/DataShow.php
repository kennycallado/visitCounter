<?php

class DataShow extends Conexion
{
  public function __construct()
  {
    $this->connect();
  }

  public function __destruct()
  {
    $this->conn->close();
  }

  private function getDefault()
  {
    $response = [];

    $firstDate = $this->conn->query('SELECT DATE(fecha) AS firstDate FROM visita LIMIT 1;');
    $totalVisitas = $this->conn->query('SELECT COUNT(*) as table_rows FROM visita;');
    $totalProcedencia = $this->conn->query('SELECT pais, COUNT(id) AS "cantidad" FROM visita GROUP BY pais;');
    $totalOs = $this->conn->query('SELECT os, COUNT(id) AS "cantidad" FROM visita GROUP BY os;');
    $totalBrowser = $this->conn->query('SELECT browser, COUNT(id) AS "cantidad" FROM visita GROUP BY browser');

    // Asigna primera fecha en la taba
    $response = $firstDate->fetch_assoc();

    if ($totalVisitas->num_rows > 0) {
      $response["amount"] = $totalVisitas->fetch_object()->table_rows;
    }

    if ($totalProcedencia->num_rows > 0) {
      $response["locations"] = [];

      if ($totalProcedencia->num_rows === 1) array_push($response["locations"], $totalProcedencia->fetch_object());
      else {
        while ($row = $totalProcedencia->fetch_object()) {
          array_push($response["locations"], $row);
        }
      }
    }

    if ($totalOs->num_rows > 0) {
      $response["system"] = [];

      if ($totalOs->num_rows === 1) array_push($response["system"], $totalOs->fetch_object());
      else {
        while ($row = $totalOs->fetch_object()) {
          array_push($response["system"], $row);
        }
      }
    }

    if ($totalBrowser->num_rows > 0) {
      $response["browsers"] = [];

      if ($totalBrowser->num_rows === 1) array_push($response["browsers"], $totalBrowser->fetch_object());
      else {
        while ($row = $totalBrowser->fetch_object()) {
          array_push($response["browsers"], $row);
        }
      }
    }

    return (object) $response;
  }

  public function showByMonth($date)
  {
    $date = explode("-", $date);
    $totalFecha = $this->conn->query('SELECT DATE(fecha) as fecha, os, browser, pais, ciudad FROM visita WHERE YEAR(fecha) = ' . $date[0] . ' AND MONTH(fecha) = ' . $date[1] . ';');

    if ($totalFecha->num_rows > 0) {
      $response = [];

      while ($row = $totalFecha->fetch_object()) {
        array_push($response, $row);
      }
    }

    return $response;
  }

  public function showByYear($year)
  {
    // Buscar una query que consulta cada mes del año
    // SELECT * FROM visita WHERE YEAR(fecha) = 2021
    $totalFecha = $this->conn->query('SELECT DATE(fecha) AS fecha FROM visita WHERE YEAR(fecha) = "' . $year . '"');

    if ($totalFecha->num_rows > 0) {
      $response = [];

      while ($row = $totalFecha->fetch_object()->fecha) {
        $response[(int)date('m', strtotime($row))] = $response[(int)date('m', strtotime($row))] + 1;
      }
    }

    return $response;
  }

  public function showDefault()
  {
    $visitas = $this->getDefault();

    return $visitas;
  }

}
