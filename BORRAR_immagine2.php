<?php 
require_once "templates/head.php";
$imagen = $_GET['id'];

$exec_imagen = $conn->prepare("SELECT * FROM painting WHERE id = :imagen");
$exec_imagen->bindParam(':imagen',$imagen);
$exec_imagen->execute();
$resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
$img = $resultado['imageUrl'];
$panoUrl = $resultado['panoUrl'];
?>

<body>
<!-- Cargamos la libreria de krpano guardada en scripts -->
<script src="scripts/pano.js"></script>


<div class="background">

<?php require_once "templates/navbar.php"; ?>

    <div class="breadcrumbs">
        <p><span>i cartoni cinquecenteschi</span> / collezione</p>
        <img src="img/cross.png" alt="cross">
    </div>

    <section class="contents">

        <!-- Usamos embedpano(una funcion de la libreria, no es algo propio de javascript) para cargar la pano dentro de un div
        La ruta a swf dirige al swf que sirve para todas las panos igual, por eso esta en pinturas 
        El xml en cambio es distinto para cada pano, por esto esta en la carpeta de la pano concreta 
        target indica donde cargar la pano
        Lo demás son opciones de la libreria -->
        <div id="pano" class="imgcont">
        <script> 
            embedpano({swf:"pinturas/pano.swf", xml:"pinturas/<?=$panoUrl?>/pano.xml", target:"pano", html5:"auto", mobilescale:1.0, passQueryParameters:true});
        </script>
        </div>

        <div class="percent">
            <img src="img/less.png" alt="down" id="less">
            <div id="progressarea"><p>xxx%</p></div>
            <!--<input type="range" id="bright" min="0" max="100" value="">-->
            <img src="img/more.png" id="more" alt="up">
        </div> <!-- en bar row-->

        <div class="iconsrow">
            <img id="mapa" src="img/mapicon.png" alt="mapa">
            <img id="brightness" src="img/brighticon.png" alt="brightness">
            <img id="infopoints" src="img/infoicon.png" alt="info">
        </div> <!-- end icons row -->

    </section>

    <?php require_once "templates/footer.php"; ?>
    
</div>
</body>

<script src="scripts/immagine.js"></script>

</html>