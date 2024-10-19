<?php
//bloquear acceso 

session_start(); // nos va a permitir manejar el login de nuestro siito web

//si no hay usuario logueado
if(!isset($_SESSION['usuario'])){

    header("Location:../index.php");

}else{
    if($_SESSION['usuario']=='ok'){
        $nombreUsuario=$_SESSION["nombreUsuario"];
    }

}



?>




<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>

    <?php

    /*redirección a otras páginas.
    Está inicializando una variable $url con el texto "http://" como parte de la construcción de una URL.$_SERVER es una superglobal en PHP que contiene información sobre el servidor y el entorno de ejecución. $_SERVER['HTTP_HOST] : Por ejemplo, si estás accediendo al sitio en www.ejemplo.com, el valor de $_SERVER['HTTP_HOST'] sería www.ejemplo.com. Si estás en un entorno de desarrollo local, podría ser localhost.Si estás en un entorno local, como en localhost, entonces $url sería algo como: http://localhost/sitioweb


    */

    $url = "http://" .$_SERVER['HTTP_HOST']. "/sitioweb"

    ?>




    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#">Administrador del sitio web<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo $url ."/administrador//"; ?> ">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url ."/administrador/seccion/productos.php"; ?>">Libros</a>
            <a class="nav-item nav-link" href="<?php echo $url ."/administrador/seccion/cerrar.php"; ?>">Cerrar sesión</a>
            <a class="nav-item nav-link" href="<?php ECHO $url; ?>">Ver sitio web</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">