# Visit counter

## Introducción

Es una sencilla aplicación que sirve de contador de visitas para algún recurso en internet. Imagina que tienes un enlace para compartir información tipo google drive, onedrive u otros, y quieres tener un contador de visitas para dicho recurso y quieres analizar un poco estas visitas. Esta aplicación se implanta en un paso previo al acceso a dicho recurso y posteriormente redirecciona hacia el contenido final. 

        usuario -> aplicación (contador) -> dirección final.

Permite redireccionar el tráfico sin pausa o mostrar una página al usuario, el cual deberá hacer click en un botón para continuar hacia el enlace final.

Se acompaña con otra página a modo de sencilla dashboard con información básica sobre las visitas a la web. Permite navegar entre meses y años, así como tener alguna información sobre navegadores y sistemas operativos.

Es un sencillo full sctack con vanilla php en el lado del servidor y conectado a una base de datos mysql. Para el front end hay algunas partes renderizadas por php y otras en html css y vanilla javascript. Para navegar entre fechas usa la api fetch del navegador. La geolocalización se obtiene a través de 'http://www.geoplugin.net/' desde el servidor, enviando la ip pública del usuario, está ip no es guardada.

## Requisitos

1. Servidor HTTP
1. Php
1. MySQL
  - Crear previamente una base de datos. Por ejemplo:
          CREATE DATABASE contador;
1. Hosting

## Estructura

``` bash
./
├── ajaxDate.php
├── analitics.php
├── autoloader.php
├── clases
│   ├── Conexion.php
│   ├── DataGet.php
│   └── DataShow.php
├── conf.ini
├── dayDetails.php
├── index.php
├── partial.html
├── readme.md
└── creaTabla.sql
```

1. **ajaxDate.php**: Endpoint que sirve de enlace con el servidor para las peticiones de fetch desde el navegador.
1. **analitics.php**: Sencilla dashboard que muestra la información de las visitas.
1. **autoloader.php**: Maneja la dependencia de clases en los ficheros que se requiere.
1. **clases**: Directorio que contiene las clases de la aplicación:
    - **Conexion.php**: Clase que gestiona la conexión con la base de datos.
    - **DataGet.php**: Clase que se encarga de obtener los datos del usuario y guardarlos en la base de datos.
    - **DataShow.php**: Clase que negocia con la base de datos para mostrar la información en `analitics.php`.
1. **conf.ini**: Parametros de configuración de la aplicación. Se detalla más adelante.
1. **Partial.html**: Al ser incrustado en index.php, tiene propiedades de renderizado de php (puede contener código php) y tiene acceso a algunas variables de la configuración a través del array asociativo `$content`:
    - `phpRedirect` -> \$content["phpRedirect"]
    - `pageDestination`
    - `title`
    - `partial`
    - `advise`
    - `button`
    - `extra` (en el caso de que se haya especificado)
1. **creaTabla.sql**: Commando sql que debe ejecutarse en mysql para crear la base de datos sobre la que funciona la aplicación.

## Configuración

Crear tabla en base de datos. Puede importar el fichero `creaTabla.sql` para generar la tabla necesaria para que la aplicación guarde los datos.

Existe un fichero principal para configurar la aplicación _conf.ini_. Este contiene algunos parámetros configurables, así como los datos para la conexión con la base de datos.

1. **GENERAL**: Parámetros generales de la aplicación, cambian el comportamiento drásticamente:
    - `phpRedirect` (boolean) ->
        - `true` redirecciona sin renderizar página principa.
        - `fale` Se mostrará la página princial con botón para continuar. 
    - `pageDestination` (string) -> Página a la que será redirigido el usuario.
    - `renderFooter` (boolean) ->
        - `true` renderizará el footer predefinido con _advise_ y _button_
        - `false` No renderizará el footer.
    - `partial` (string) -> ubicación del fichero partial que se incrustará en la página principal de la aplicación.
    - `extra` (unknow) -> Permite almacenar cualquier valor que después ser accesible desde `partial`. Puede contener un string, número, array, array asociativo, dependiendo de las necesidades.
        - *Ejemplo*:

        ``` php
        extra[] = 'foo'
        extra[] = 'bar'

        <?= $content["extra"][0]; ?> // result > foo 
        <?= $content["extra"][1]; ?> // result > bar 
        ```

        ``` php
        extra[foo] = 'foo'
        extra[bar] = 'bar'

        <?= $content["extra"][foo]; ?> // result > foo 
        <?= $content["extra"][bar]; ?> // result > bar 
        ```

    El contenido se extenderá sobre `$content["extra"]`

2. **CONTENT**: Algunos contenidos que se incluiran en el título y footer de la página principal.
    - `title` (string) -> Contiene titulo que aparecerá en la pestaña del navegador
    - `advise` (string) -> Párrafo previo al botón de redirección.
    - `button` (string) -> Palabra que contendrá el botón de redirección.

3. **DATABASE**: Contiene los parámetros de conexión con la base de datos.
    - `host` (string) -> Dirección de la base de datos.
    - `user` (string) -> Usuario de la base de datos.
    - `pass` (string) -> Contraseña para el usuario en la base de datos.
    - `bdat` (string) -> Nombre de la base de datos que usará en mysql.

## Todo list:

- Limpiar:
    - Algunos métodos de las clases no se usan.
- Revisar estructura de clases.
- Mejorar comentarios.

