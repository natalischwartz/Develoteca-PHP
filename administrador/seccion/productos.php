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

      //adjuntar imagen

      /*significa que estás creando una nueva instancia de la clase DateTime en PHP. Esta clase representa una fecha y hora.DateTime(): Es el constructor de la clase DateTime, que cuando se llama sin ningún parámetro, por defecto crea un objeto que representa la fecha y hora actual (según la zona horaria del servidor).$fecha: Es la variable que almacenará el objeto DateTime, que contiene la fecha y hora actual en el momento de la creación del objeto.
      */
      $fecha = new DateTime();


      /*Esta línea de código utiliza un operador ternario para asignar un valor a la variable $nombreArchivo dependiendo de si se ha subido una imagen o no.
      ($txtImagen != ""): Aquí se está verificando si la variable $txtImagen (que probablemente almacena el nombre o ruta de una imagen) no está vacía. Si contiene algún valor, significa que se ha seleccionado una imagen para subir.
      Si $txtImagen no está vacío, se genera un nombre de archivo único concatenando la marca de tiempo actual ($fecha->getTimestamp() devuelve el número de segundos desde el 1 de enero de 1970) con el nombre del archivo original ($_FILES["txtImagen"]["name"]).
      Esto evita posibles colisiones de nombres entre archivos al agregar la marca de tiempo (timestamp) al principio del nombre del archivo.
      El resultado será algo como 1697285325_nombreOriginal.jpg.

      Si $txtImagen está vacío, es decir, si no se ha seleccionado ninguna imagen, se asigna un nombre de archivo por defecto, en este caso "imagen.jpg".

      Este código asigna un nombre único a los archivos de imagen que se suben, combinando la fecha y el nombre original del archivo.
      */
      $nombreArchivo = ($txtImagen != "") ? $fecha-> getTimestamp(). "_".$_FILES["txtImagen"]["name"] : "imagen.jpg";


      
      //Este código se encarga de mover una imagen que ha sido subida por un usuario desde una ubicación temporal en el servidor hacia un directorio definitivo en el servidor, si es que la imagen existe.
      
      //$tmpImagen = $_FILES["txtImagen"]["tmp_name"];: Aquí se accede a la ubicación temporal del archivo de imagen que se ha subido mediante el formulario HTML.$_FILES[$txtImagen]["tmp_name"] devuelve la ruta temporal donde se almacena el archivo en el servidor antes de ser procesado. El valor de $_FILES es un array global que PHP llena automáticamente cuando se suben archivos mediante un formulario.
      //$txtImagen es el nombre del campo del formulario que contiene la imagen seleccionada por el usuario.

      $tmpImagen = $_FILES["txtImagen"]["tmp_name"];


      //Se está verificando si la variable $tmpImagen no está vacía. Esto significa que se está comprobando si efectivamente se ha subido una imagen y si existe una ruta temporal válida.
      //Si no está vacía, el código dentro del if se ejecuta, lo que implica que hay un archivo que se puede mover.

      if($tmpImagen!=""){

        //move_uploaded_file es una función de PHP que mueve un archivo subido desde su ubicación temporal a una ubicación definitiva en el servidor.
        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

      }

        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        // echo $sentenciaSQL->queryString;
        $sentenciaSQL->execute();


        header("Location:productos.php");
        break;

    case "Modificar":
      //es una sentencia SQL de actualización. UPDATE libros: Esta parte de la consulta indica que se va a actualizar una fila en la tabla libros. SET nombre=:nombre: Aquí se especifica que el valor de la columna nombre se actualizará con un nuevo valor que se pasa como parámetro (:nombre). WHERE id=:id: La condición WHERE indica que solo se actualizará la fila que tenga el id igual al valor del parámetro :id. De esta manera, te aseguras de que solo se modifique un registro específico de la tabla.

      $sentenciaSQL =$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
      $sentenciaSQL->bindParam(':nombre',$txtNombre);
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();


      //vamos a modificar la imagen si el campo txtImagen no es vacío. osea tiene informacion

      if($txtImagen != ""){

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha-> getTimestamp(). "_".$_FILES["txtImagen"]["name"] : "imagen.jpg";
        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];


        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);


        $sentenciaSQL =$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        //fetch(): Este método recupera una fila (un registro) del resultado de la consulta
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY); //esto va a hacer posible que yo pueda cargar los datos y rellenarlos uno a uno 
  
        if(isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")){
  
          if(file_exists("../../img/".$libro["imagen"])){
            unlink("../../img/".$libro["imagen"]);
          }
  
        }




        $sentenciaSQL =$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
      }
    
      header("Location:productos.php");


        
        break;
        
    case "Cancelar":

      //cuando cancelemos vamos a redirigir a la seccion de productos
      header("Location:productos.php");

        // echo "presionado boton cancelar";
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

      //borrar imagen que esta dentro de la carpeta img



      $sentenciaSQL =$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();
      //fetch(): Este método recupera una fila (un registro) del resultado de la consulta
      $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY); //esto va a hacer posible que yo pueda cargar los datos y rellenarlos uno a uno 

      if(isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")){

        if(file_exists("../../img/".$libro["imagen"])){
          unlink("../../img/".$libro["imagen"]);
        }

      }



      //Borrar registro 
      //Este código ejecuta una sentencia para eliminar un registro de la tabla libros en la base de datos basándose en un valor específico del campo id.La consulta DELETE FROM libros WHERE id=:id significa que se va a eliminar un registro de la tabla libros donde el campo id coincida con el valor que se va a proporcionar. Si, por ejemplo, $txtID = 3, entonces el valor 3 será el que se asigne al marcador :id. Esto hará que la consulta eliminatoria quede así: DELETE FROM libros WHERE id=3, eliminando el libro con id = 3 de la tabla libros.

      $sentenciaSQL =$conexion->prepare("DELETE FROM libros WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();
      header("Location:productos.php");
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
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID"  placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del libro">
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>

                    

                  <?php echo $txtImagen ?>

                  <br>


                  <?php if( $txtImagen != ""){ ?>

                      <!--mostramos la imagen-->
                      <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="">  


                <?php } ?>





                    <input type="file"  class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del libro">
                </div>


                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo($accion=="Seleccionar"? "disabled":""); ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion"  <?php echo($accion!="Seleccionar"? "disabled":""); ?>  value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion"  <?php echo($accion!="Seleccionar"? "disabled":""); ?> value="Cancelar" class="btn btn-info">Cancelar</button>
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
                <td>

                <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="">  
                
                
              
              
              
              </td><!--es la columna imagen de la tabla-->
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