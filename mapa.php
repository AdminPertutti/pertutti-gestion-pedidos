<?php

/*
Enviar formulario con petición HTTP POST
en PHP
@author parzibyte
https://parzibyte.me/blog
 */
$data = $_POST['consulta'];
$direccion = str_replace(" ", "+", $data);
$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=espana+299+lomas+de+zamora&destinations=". $direccion ."&mode=bicycling&language=es-SP&key=AIzaSyBGzi4W4pDJNiB2VCpjIA3yKSvJDTsX-3o";
// Los datos de formulario
$datos = [];
// Crear opciones de la petición HTTP
$opciones = array(
    "http" => array(
        "header" => "Content-type: application/json\r\n",
        "method" => "GET",
        "content" => http_build_query($datos), # Agregar el contenido definido antes
    ),
);
# Preparar petición
$contexto = stream_context_create($opciones);
# Hacerla
$resultado = file_get_contents($url, false, $contexto);
if ($resultado === false) {
    echo "Error haciendo petición";
    exit;
}

# si no salimos allá arriba, todo va bien
echo $resultado;
