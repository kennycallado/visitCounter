<?php

// Carga autolader
require_once('autoloader.php');

$data = new DataShow();
$info = $data->showDefault();

$content = DataGet::getConfig();

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $content["title"]; ?></title>
  <style>
    td {
      padding: 0.5rem;
    }
  </style>
</head>

<body>
  <h1 style="text-align: center;">Estadistica de visitas a <span style="color: #0CC; font-weight: bold;"><?= $content["title"] ?></span></h1>
  <p style="text-align: center;">Total de visitas: <span style="font-size: 1.5rem;"><?= $info->amount ?></span> desde: <?= $info->firstDate ?></p>
  <div style="display: flex;">
    <div style="width: 100%; border: 2px solid black; margin-right: 2px;">
      <h4 style="text-align: center; background-color: tan;">Paises ⚐</h4>
      <table style="margin-left: auto; margin-right: auto;">
        <thead>
          <tr>
            <th>País proc.</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <?php
        foreach ($info->locations as $item) {
          echo '<tr><td style="text-align: center;">' . $item->pais . '</td><td style="text-align: center;">' . $item->cantidad . '</td></tr>';
        } ?>
      </table>
    </div>
    <div style="width: 100%; border: 2px solid black; margin-right: 2px;">
      <h4 style="text-align: center; background-color: tan;">Navegadores 🏄</h4>
      <table style="margin-left: auto; margin-right: auto;">
        <thead>
          <tr>
            <th>Navegadores</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <?php
        foreach ($info->browsers as $item) {
          echo '<tr><td style="text-align: center;">' . $item->browser . '</td><td style="text-align: center;">' . $item->cantidad . '</td></tr>';
        } ?>
      </table>
    </div>
    <div style="width: 100%; border: 2px solid black;">
      <h4 style="text-align: center; background-color: tan;">S. Operativos 🗔</h4>
      <table style="margin-left: auto; margin-right: auto;">
        <thead>
          <tr>
            <th>Sistema Ope.</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <?php
        foreach ($info->system as $item) {
          echo '<tr><td style="text-align: center;">' . $item->os . '</td><td style="text-align: center;">' . $item->cantidad . '</td></tr>';
        } ?>
      </table>
    </div>
  </div>
  <div style="display: flex; margin-top: 2rem;">
    <div style="width: 100%; border: 2px solid black; margin: 0 auto;">
      <h4 style="text-align: center; background-color: tan;"><button id="prevy" style="color: red; cursor: wait;">⇐</button> visitas <span id="year"></span> 📅 <button id="nexty" style="color: red; cursor: wait;">⇒</button></h4>
      <p style="text-align:center;">Total visitas anual: <span id="totalyear"></span></p>
      <div style="display: flex;">
        <table style="width: 100%; border-right: 1px solid black;">
          <thead>
            <tr>
              <th>Mes</th>
              <th>Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align: right;">Enero</td>
              <td style="text-align: center;" id="enero"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Febrero</td>
              <td style="text-align: center;" id="febrero"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Marzo</td>
              <td style="text-align: center;" id="marzo"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Abril</td>
              <td style="text-align: center;" id="abril"></td>
            </tr>
          </tbody>
        </table>
        <table style="width: 100%; border-right: 1px solid black;">
          <thead>
            <tr>
              <th>Mes</th>
              <th>Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align: right;">Mayo</td>
              <td style="text-align: center;" id="mayo"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Junio</td>
              <td style="text-align: center;" id="junio"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Julio</td>
              <td style="text-align: center;" id="julio"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Agosto</td>
              <td style="text-align: center;" id="agosto"></td>
            </tr>
          </tbody>
        </table>
        <table style="width: 100%;">
          <thead>
            <tr>
              <th>Mes</th>
              <th>Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="text-align: right;">Septiembre</td>
              <td style="text-align: center;" id="septiembre"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Octubre</td>
              <td style="text-align: center;" id="octubre"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Noviembre</td>
              <td style="text-align: center;" id="noviembre"></td>
            </tr>
            <tr>
              <td style="text-align: right;">Diciembre</td>
              <td style="text-align: center;" id="diciembre"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div style="display: flex; margin-top: 2rem;">
    <div style="width: 75%; border: 2px solid black; margin: 0 auto;">
      <h4 style="text-align: center; background-color: tan;"><button id="prevm" style="color: red; cursor: wait;">⇐</button> visitas <span id="fecha"></span> 📅 <button id="nextm" style="color: red; cursor: wait;">⇒</button></h4>
      <table style="margin-left: auto; margin-right: auto;">
        <thead>
          <tr>
            <th style="border-right: 1px solid black;">Fecha completa</th>
            <th style="border-right: 1px solid black;">Os</th>
            <th style="border-right: 1px solid black;">Browser</th>
            <th style="border-right: 1px solid black;">Pais</th>
            <th>Ciudad</th>
          </tr>
        </thead>
        <tbody id="monthDetail"></tbody>
      </table>
    </div>
  </div>
  <script>
    today = new Date();
    currentMonth = today.getMonth() + 1;
    currentYear = today.getFullYear();

    currentDate = (currentMonth < 10) ? `${currentYear}-0${currentMonth}` : `${currentYear}-${currentMonth}`

    spanMonth = document.querySelector("#fecha");
    spanMonth.innerText = currentDate;

    spanYear = document.querySelector("#year");
    spanYear.innerText = currentYear;

    spanTotalYear = document.querySelector('#totalyear');

    monthDetail = document.querySelector('#monthDetail');

    fetchYearInfo();
    fetchMonthInfo();

    function fetchYearInfo() {
      fetch(window.location.origin + "/ajaxDate.php?year=" + currentYear, {
          method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
          if (!data) alert("No se ha podido resolver la petición.");

          // El total de visitas es la suma de todos.
          let total = 0;

          // Recorrer array para recoger elementos
          for (item in data) {
            total = total + data[item]
            element = document.querySelector("#" + item);
            element.innerText = data[item];
          }
          spanTotalYear.innerText = total;
        })
    }

    function fetchMonthInfo() {
      fetch(window.location.origin + "/ajaxDate.php?month=" + currentDate, {
          method: 'GET'
        })
        .then(response => response.json())
        .then(visits => {
          if (!visits) {
            while (monthDetail.firstChild) {
              monthDetail.removeChild(monthDetail.firstChild)
            }
            return
          }

          monthDetail = document.querySelector('#monthDetail');
          while (monthDetail.firstChild) {
            monthDetail.removeChild(monthDetail.firstChild)
          }

          for (visit of visits) {
            tr = document.createElement("tr");
            Object.keys(visit).forEach(key => {
              td = document.createElement("td");
              if (key !== "ciudad") {
                td.style.borderRight = "1px solid black"
              }
              td.innerText = visit[key];
              tr.insertAdjacentElement('beforeend', td);
            });
            monthDetail.insertAdjacentElement('afterbegin', tr);
          }
        })
    }

    function updateSpanMonth() {
      spanMonth.innerText = currentDate;
      fetchMonthInfo();
    }

    function updateSpanYear() {
      spanYear.innerText = currentYear;
      fetchYearInfo();
    }

    function nextMonth() {
      date = currentDate.split('-', 2);

      year = date[0]
      month = date[1]

      if (month == 12) {
        year++;
        month = 1;
        nextYear();
      } else {
        month = Number(month) + 1;
      }


      if (month < 10) currentDate = `${year}-0${month}`;
      else currentDate = `${year}-${month}`;

      updateSpanMonth();
    }

    function prevMonth() {
      date = currentDate.split('-', 2);

      year = date[0]
      month = date[1]

      if (month == 1) {
        year--;
        month = 12;
        prevYear();
      } else {
        month = Number(month) - 1;
      }


      if (month < 10) currentDate = `${year}-0${month}`;
      else currentDate = `${year}-${month}`;

      updateSpanMonth();
    }

    function nextYear() {
      currentYear++;

      currentDate = `${currentYear}-${currentMonth}`;

      updateSpanMonth();
      updateSpanYear();
    }

    function prevYear() {
      currentYear--;

      currentDate = `${currentYear}-${currentMonth}`;

      updateSpanMonth();
      updateSpanYear();
    }

    prevM = document.querySelector('#prevm');
    prevM.addEventListener('click', prevMonth);

    nextM = document.querySelector('#nextm');
    nextM.addEventListener('click', nextMonth);

    prevY = document.querySelector('#prevy');
    prevY.addEventListener('click', prevYear);

    nextY = document.querySelector('#nexty');
    nextY.addEventListener('click', nextYear);
  </script>
</body>

</html>
