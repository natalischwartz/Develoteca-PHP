<?php include("../template/cabecera.php");  ?>

<?php

//validaremos con un if ternario.La función isset() verifica si la variable $_POST['txtID'] está definida y no es null. En este caso, verifica si se ha enviado el valor del campo txtID a través del formulario mediante el método POST. $_POST['txtID']: Si el campo txtID ha sido enviado (es decir, si isset($_POST['txtID']) es verdadero), el valor que se ingresó en el campo del formulario txtID se asigna a la variable $txtID.

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";

//$_FILES['txtImagen']['name'] devuelve el nombre original del archivo subido. Si isset($_FILES['txtImagen']['name']) es verdadero (es decir, si se subió un archivo y tiene un nombre), se le asigna el nombre del archivo a $txtImagen.
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

// echo $txtID."<br>"; // 2
// echo $txtNombre."<br>";// php
// echo $txtImagen."<br>";// pexels-photo-11035390.webp
// echo $accion."<br>";// agregar



//va a evaluar la acción
switch($accion){ // cada uno de los case tienen el valor que tiene dentro value

    case "Agregar":

        
        //$conexion->prepare(): Este método prepara una sentencia SQL para ser ejecutada más tarde. Utilizar prepare() es importante porque ayuda a prevenir inyecciones SQL y hace que el código sea más eficiente al permitir que la consulta sea compilada y reutilizada.
        //INSERT INTO libros: Es una instrucción SQL para insertar un nuevo registro en la tabla libros.$sentenciaSQL->execute(): Ejecuta la sentencia SQL que fue preparada con prepare()
        $sentenciaSQL =$conexion->prepare("INSERT INTO libros (nombre,imagen) VALUES (:nombre,:imagen);");
        /*bindParam(): Este método vincula (o enlaza) un valor de una variable PHP a un marcador de posición en la sentencia preparada. En este caso:
        El marcador :nombre se vincula a la variable PHP $txtNombre.
        El marcador :imagen se vincula a la variable PHP $txtImagen.
        Esto significa que cuando la sentencia se ejecute, los valores almacenados en las variables $txtNombre y $txtImagen serán insertados en la tabla libros en las columnas nombre e imagen, respectivamente.
        */
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':imagen',$txtImagen);
        // echo $sentenciaSQL->queryString;
        $sentenciaSQL->execute();
        break;

    case "Modificar":
        echo "presionado boton modificar";
        break;
        
    case "Cancelar":
        echo "presionado boton cancelar";
        break;
    case "Seleccionar":
      //Selecciona los libros cuyo id coinciden con el id que se selecciono
      $sentenciaSQL =$conexion->prepare("SELECT * FROM libros WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();
      //fetch(): Este método recupera una fila (un registro) del resultado de la consulta
      $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY); //esto va a hacer posible que yo pueda cargar los datos y rellenarlos uno a uno 
        
      $txtNombre = $libro['nombre'];//Aquí se está accediendo al valor de la columna nombre de la fila obtenida.
      $txtImagen = $libro['imagen'];


        break;
    case "Borrar":
      //Este código ejecuta una sentencia para eliminar un registro de la tabla libros en la base de datos basándose en un valor específico del campo id.La consulta DELETE FROM libros WHERE id=:id significa que se va a eliminar un registro de la tabla libros donde el campo id coincida con el valor que se va a proporcionar. Si, por ejemplo, $txtID = 3, entonces el valor 3 será el que se asigne al marcador :id. Esto hará que la consulta eliminatoria quede así: DELETE FROM libros WHERE id=3, eliminando el libro con id = 3 de la tabla libros.

      $sentenciaSQL =$conexion->prepare("DELETE FROM libros WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();

        //echo "presionado boton borrar";
        break;

}


//chequeamos que estan llegando los datos

// print_r($_POST); //Array ( [txtID] => [txtNombre] => php [accion] => agregar ) 

// print_r($_FILES);//Array ( [txtImagen] => Array ( [name] => pexels-photo-11035390.webp [full_path] => pexels-photo-11035390.webp [type] => image/webp [tmp_name]

/*código está ejecutando una consulta para obtener todos los registros de la tabla libros en la base de datos y almacenar los resultados en un arreglo.
La consulta SELECT * FROM libros indica que se recuperarán todas las columnas (* significa "todas las columnas") y todos los registros de la tabla libros.
fetchAll(PDO::FETCH_ASSOC): Este método recupera todos los resultados de la consulta en forma de un arreglo asociativo. Cada fila de la tabla libros se convierte en un arreglo, donde las claves corresponden a los nombres de las columnas de la tabla, y los valores son los datos de cada registro.cada registro sería representado así:
[
    'id' => 1,
    'nombre' => 'Libro de PHP',
    'imagen' => 'php_libro.jpg'
]
$listaLibros, será un arreglo que contiene todos los registros de la tabla libros. Por ejemplo:
$listaLibros = [
  [
    'id' => 1,
    'nombre' => 'Libro de PHP',
    'imagen' => 'php_libro.jpg'
  ],
  [
    'id' => 2,
    'nombre' => 'Libro de MySQL',
    'imagen' => 'mysql_libro.jpg'
  ]
];

*/
$sentenciaSQL =$conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?> 

<?php
// rececpionamos con php qué boton se apreto con el atributo name
/*
$_POST:

Es una superglobal de PHP que contiene los datos enviados mediante un formulario HTML usando el método POST. Es un arreglo asociativo que almacena los valores enviados por el formulario.donde cada clave es el nombre del campo del formulario y el valor es lo que se ingresó en ese campo. print_r():Es una función de PHP que imprime información legible para los humanos sobre una variable.

Array ( [txtID] => [txtNombre]=> php [accion] =>)

*/

?>



<!--Formulario de agregar libros-->
<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data" action="">

                <div class = "form-group">
                    <label for="txtID">ID:</label><!--value es el prellando-->
                    <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID"  placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $txtNombre ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del libro">
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>

                  <?php echo $txtImagen ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del libro">
                </div>


                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion"  value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>

            



        </div>

        
    </div>

    
    
    



</div>


<!--Tabla de libros(mostrar los datos de la BD)-->
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($listaLibros as $libro) { ?>
            <tr>
                <td><?php echo $libro['id']; ?></td>
                <td><?php echo $libro['nombre']; ?></td> <!--es la columna nombre de la tabla-->
                <td><?php echo $libro['imagen']; ?></td><!--es la columna imagen de la tabla-->
                <td>
                
                <form method="POST">

                  <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">

                  <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                  <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
              
              
              </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php");  ?>