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

    // Pruebas
    // SELECT  DATE_FORMAT(fecha, '%Y-%c-%e') AS fecha, COUNT(id) AS "cantidad" FROM visita GROUP BY fecha LIMIT 7
    // $totalFecha = $this->conn->query('SELECT DATE(fecha) AS fechaShort, COUNT(id) AS "cantidad" FROM visita WHERE fecha > (NOW() - INTERVAL 1 MONTH) GROUP BY fechaShort');

    $firstDate = $this->conn->query('SELECT DATE(fecha) AS firstDate FROM visita LIMIT 1;');
    $totalVisitas = $this->conn->query('SELECT COUNT(*) as table_rows FROM visita;');
    // $totalFecha = $this->conn->query('SELECT * FROM visita WHERE MONTH(fecha) = MONTH(NOW()) AND YEAR(fecha) = YEAR(NOW())');
    $totalProcedencia = $this->conn->query('SELECT pais, COUNT(id) AS "cantidad" FROM visita GROUP BY pais;');
    $totalOs = $this->conn->query('SELECT os, COUNT(id) AS "cantidad" FROM visita GROUP BY os;');
    $totalBrowser = $this->conn->query('SELECT browser, COUNT(id) AS "cantidad" FROM visita GROUP BY browser');

    // Asigna primera fecha en la taba
    $response = $firstDate->fetch_assoc();

    if ($totalVisitas->num_rows > 0) {
      $response["amount"] = $totalVisitas->fetch_object()->table_rows;
    }

    // if($totalFecha->num_rows > 0) {
    //   $response["dates"] = [];

    //   while ($row = $totalFecha->fetch_object()) {
    //     array_push($response["dates"], $row);
    //   }
    // }

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

  private function getTotal()
  {
    $totalVisitas = $this->conn->query('SELECT COUNT(*) as table_rows FROM visita;');

    if ($totalVisitas->num_rows > 0) {

      return $totalVisitas->fetch_object()->table_rows;
    } else die("Algún problema con la petición. (getTotal)");
  }

  private function getByDate($date)
  {
    $totalFecha = $this->conn->query('SELECT * FROM `visita` WHERE DATE(fecha) = "' . $date . '"');
    // SELECT * FROM visita WHERE YEAR(fecha) = 2021 AND MONTH(fecha) = 6

    if ($totalFecha->num_rows > 0) {
      $response = [];

      while ($row = $totalFecha->fetch_object()) {
        array_push($response, $row);
      }
    } else die("Algún problema con la petición. (getByDate)");

    return $response;
  }

  private function getByCountry()
  {
    // $totalVisitas = $this->conn->query('SELECT table_rows FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "vecino";');
    // $totalVisitas = $this->conn->query('SELECT COUNT(*) as table_rows FROM visita;');
    $totalProcedencia = $this->conn->query('SELECT procedencia, COUNT(id) AS "cantidad" FROM visita GROUP BY procedencia;');

    if ($totalProcedencia->num_rows > 0) {
      // $response = (object)["totalVisitas" => $totalVisitas->fetch_object()->table_rows];
      $response = [];

      if ($totalProcedencia->num_rows === 1) array_push($response, $totalProcedencia->fetch_object());
      else {
        while ($row = $totalProcedencia->fetch_object()) {
          array_push($response, $row);
        }
      }
    } else die("Algún problema con la peticion. (getByCountry)");

    // Envía objeto resultado
    return $response;
  }

  public function showByDate($date)
  {
    return $this->getByDate($date);
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

  public function showAll()
  {

    $visitas = (object)[
      "totalVisitas" => $this->getTotal(),
      "procedenciaVisitas" => $this->getByCountry(),
      // "fechaVisitas" => $this->getByDate(),
    ];

    // Muestra total
    echo "<table>";
    echo "<tr>";
    echo "<th>Total Visitas:</th>";
    echo "<td>$visitas->totalVisitas</td>";
    echo "</tr>";
    echo "</table>";

    // Muestra por procedencia
    echo "<table style='display: inline-block;'>";
    echo "<tr>";
    echo "<th>procedencia</th>";
    echo "<th>cantidad</th>";
    echo "</tr>";
    foreach ($visitas->procedenciaVisitas as $visita) {
      echo "<tr>";
      echo "<td>$visita->procedencia</td>";
      echo "<td style='text-align: center;'>$visita->cantidad</td>";
      echo "</tr>";
    }
    echo "</table>";

    // Muestra por fecha
    echo "<table style='display: inline-block;'>";
    echo "<tr>";
    echo "<th>procedencia</th>";
    echo "<th>cantidad</th>";
    echo "</tr>";

    foreach ($visitas->fechaVisitas as $visita) {
      echo "<tr>";
      echo "<td>$visita->fecha</td>";
      echo "<td style='text-align: center;'>$visita->cantidad</td>";
      echo "</tr>";
    }

    echo "</table>";
  }
}
