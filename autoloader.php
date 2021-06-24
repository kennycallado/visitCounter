<?php

spl_autoload_register(function ($nombre){
  $fichero = "clases/{$nombre}.php";
  if(is_file($fichero)) {
    require_once $fichero;
  } else echo "Error, autoloader no encuentra fichero";
});

?>
