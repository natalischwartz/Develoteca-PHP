<?php include ("template/cabecera.php");  ?>

<?php include("administrador/config/bd.php"); ?>

<?php
$sentenciaSQL =$conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaLibros as $libro){ ?>

    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="img/<?php echo $libro['imagen']; ?>" alt="<?php echo $libro['nombre'] ?>">
            <div class="card-body">
                <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
                <a target="__blank" name="" id="" class="btn btn-primary" href="https://goalkicker.com/" role="button"> Ver más</a>
            </div>
        </div>
    </div>
<?php } ?>



<!-- <div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar5.png" alt="">
        <div class="card-body">
            <h4 class="card-title">Libro php</h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button"> Ver más</a>
        </div>
    </div>
</div> -->

<!-- <div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar5.png" alt="">
        <div class="card-body">
            <h4 class="card-title">Libro php</h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button"> Ver más</a>
        </div>
    </div>
</div> -->

<!-- <div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar5.png" alt="">
        <div class="card-body">
            <h4 class="card-title">Libro php</h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button"> Ver más</a>
        </div>
    </div>
</div> -->

<!-- <div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar5.png" alt="">
        <div class="card-body">
            <h4 class="card-title">Libro php</h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button"> Ver más</a>
        </div>
    </div>
</div> -->








<?php include ("template/pie.php");  ?>