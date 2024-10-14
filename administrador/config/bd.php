<?php // nos vamos a conectar a una base de dato ?>

<?php


$host="localhost";//Especifica el servidor donde se encuentra la base de datos, que en este caso es localhost (es decir, en el mismo servidor donde se ejecuta este script).
$bd ="supernatali";//Define el nombre de la base de datos a la que se va a conectar
$usuario="root";//Define el nombre de usuario para conectarse a MySQL,
$contrasenia ="";

//Este código en PHP intenta conectarse a una base de datos MySQL utilizando PDO (PHP Data Objects), que es una interfaz para acceder a bases de datos
try {
    $conexion= new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
    
} catch (Exception $ex) {
    echo $ex-> getMessage();
}

?>