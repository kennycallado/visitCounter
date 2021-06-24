<?php

// Creo que lo mejor sería crear una clase para obtener la informació
// y guardarla en base de datos y otra clase para obtener la informació
// y mostrarla.

// Continuar por save() -> ya se obtiene la información y ahora se debe guardar

class DataGet extends Conexion
{
  protected $user = [];

  public function __construct($userAgent, $address)
  {
    // Asigna propiedades
    $this->user["browser"] = $this->browser($userAgent);
    $this->user["os"] = $this->os($userAgent);
    $this->user["location"] = $this->fetchLocation($address);

    // Conecta la base de datos
    $this->connect();
  }

  public function __destruct()
  {
    $this->conn->close();
  }

  private function fetchLocation($address)
  {
    $array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $address));

    $response = array(
      "pais"      => htmlspecialchars($array["geoplugin_countryName"]),
      "comunidad" => htmlspecialchars($array["geoplugin_region"]),
      "provincia" => htmlspecialchars($array["geoplugin_regionName"]),
      "ciudad"    => htmlspecialchars($array["geoplugin_city"]),
    );

    return $response;
  }

  static function getConfig()
  {
    $response = [];
    if (file_exists('conf.ini')) {
      $fichero = parse_ini_file('conf.ini');

      $response["phpRedirect"] = $fichero["phpRedirect"];
      $response["pageDestination"] = $fichero["pageDestination"];
      $response["partial"] = $fichero["partial"];
      $response["title"] = $fichero["title"];
      $response["advise"] = $fichero["advise"];
      $response["button"] = $fichero["button"];
      $response["printFooter"] = $fichero["printFooter"];

      // var_dump($fichero["extra"]);
      if($fichero["extra"]) $response["extra"] = $fichero["extra"];

    } else die('No existe "conf.ini, necesario para continuar"');

    return $response;
  }

  private function browser($userAgent)
  {
    $ua = strtolower($userAgent);

    $browser = array(
      "Edge"                => "/edge(.*)/i",
      "Chromiun"            => "/chromium(.*)/i",
      "Navigator"           => "/navigator(.*)/i",
      "Firefox"             => "/firefox(.*)/i",
      "Internet Explorer"   => "/msie(.*)/i",
      "Google Chrome"       => "/chrome(.*)/i",
      "Opera"               => "/opera(.*)/i",
      "w3m"                 => "/w3m(.*)/i",
    );

    foreach ($browser as $key => $value) {
      if (preg_match($value, $ua)) {
        // Get version
        preg_match($value, $ua, $version);
        return $key . $version[1];
      }
    }
  }

  private function os($userAgent)
  {
    $OS = array(
      "Windows"   =>   "/Windows/i",
      "Android"   =>   "/Android/i",
      "Linux"     =>   "/Linux/i",
      "Unix"      =>   "/Unix/i",
      "Mac"       =>   "/Mac/i"
    );

    foreach ($OS as $key => $value) {
      if (preg_match($value, $userAgent)) {
        return $key;
      }
    }

    // return
  }

  public function save()
  {
    $query = 'INSERT INTO visita VALUES ( NULL, NOW(), "' . $this->user['os'] . '","' .  $this->user['browser'] . '","' .  $this->user['location']['pais'] . '","' .  $this->user['location']['comunidad'] . '","' .  $this->user['location']['provincia'] . '","' .  $this->user['location']['ciudad'] . '")';

    if (!$this->conn->query($query)) return ("Error description: " . $this->conn->error);
  }
}
