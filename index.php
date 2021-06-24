<?php

// Carga autolader
require_once('autoloader.php');

// Obtiene info del navegador y la guarda en base de datos
$data = new DataGet($_SERVER['HTTP_USER_AGENT'], $_SERVER['REMOTE_ADDR']);
$data->save();

// Obtiene contendio desde fichero configuración
$content = $data->getConfig();

// Si está activo redirección con php se acciona
if ($content["phpRedirect"]) {
  header("Location: $content[pageDestination]");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $content["title"] ?></title>
</head>

<body>

  <?php if ($content["partial"]) {
    include("$content[partial]");
  } ?>

  <?php

  if ($content["printFooter"]) {
    echo
    "<footer>" .
      "<p style='margin-bottom: 0;'>$content[advise]</p>" .
      "<button style='margin-left: 1rem;' id='continuarButton'>$content[button]</button>" .
      "</footer>";
  }

  ?>

  <script>
    let continuarButton = document.querySelector('#continuarButton');

    continuarButton.addEventListener('click', () => {
      document.location.href = "<?= $content["pageDestination"]; ?>";
    });
  </script>
</body>

</html>
