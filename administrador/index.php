<?php

/*haremos una pagina de login. antes de entrar al administrador tenemos que pedir un usuario y contraseña. 
las personas que se loguean podran ingresar a administrador.
*/

?>

<?php
//cuando le demos click a enviar del form. ese envio se tiene que recibir con php. algo tiene que suceder cuando yo recibo esos datos.
//recepción de datos.

/*$_POST:

Es una variable global en PHP que contiene los datos enviados a través de un formulario HTML usando el método POST. Si hay datos en $_POST, significa que el formulario fue enviado y contiene información.
La condición if ($_POST) verifica si se ha enviado un formulario (si no está vacío), lo que sería evaluado como true.
header('Location: inicio.php');:

Esta línea redirige al usuario a otra página, en este caso, inicio.php. El método header() envía encabezados HTTP al navegador, y el encabezado 'Location' se utiliza para redireccionar a otra URL.*/

if($_POST){
    header('Location:inicio.php');

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
    
        <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto mt-5">

                    <div class="card">
                        <div class="card-header">
                            Login
                        </div>
                        <div class="card-body">
                            <!--el usuario y contraseña se van a enviar a index.php que va a redirecionar. los envios de datos se hacen con post-->
                            <form method="POST">
                                <div class = "form-group">
                                    <label>Usuario</label>
                                    <input name="usuario" type="text" class="form-control"   placeholder="Ingresa usuario">
                                    
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Contraseña:</label>
                                    <input name="contrasenia" type="password" class="form-control"  placeholder="Contraseña">
                                </div>
                            
                                <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                            </form>
                            
                            
                        
                        </div>
                    
                    </div>
                    
                </div>
                
            </div>
        </div>

    </body>
</html>


