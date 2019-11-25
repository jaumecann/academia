<?php 
    require_once "templates/head.php";
    $imagen = $_GET['id'];

    $exec_imagen = $conn->prepare("SELECT * FROM cartones INNER JOIN author ON cartones.author_id = author.id WHERE cartones.id = :imagen");
    if(!$exec_imagen){
        print_r($conn->errorInfo());
    }
    $exec_imagen->bindParam(':imagen',$imagen);
    $exec_imagen->execute();
    if(!$exec_imagen){
        print_r($conn->errorInfo());
    }
    $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);

    $img = $resultado['previewUrl'];
    $img_sobreposada = $resultado['imageUrl_sobreposada'];
    $descriptionIta = $resultado['descriptionIta'];
    $material = $resultado['material'];
    $title = $resultado['title'];

    $nombre_autor = $resultado['name'];
    $birthYear_autor = $resultado['birthYear'];
    $deathYear_autor = $resultado['deathYear'];
    $birthPlace_autor = $resultado['birthPlace'];
    $deathPlace_autor = $resultado['deathPlace'];
?>
<body>

<div class="background">

<?php 
    require_once "templates/navbar.php";
?>
    <div class="breadcrumbs">
        <p class="playfair"><a href="home.php">i cartoni cinquecenteschi</a> /<span class="bread2"> <?=$title?> </span></p>
        <a class="close_breadcrumbs" href="home.php"><img src="img/cross.png" alt="go back">
    </div></a>

    <section id="cartone">
        <div class="imgdiv"><img src="pinturas/<?=$img?>"></div>
        <div class="bigtxtdiv">
            <h3 class="titulo-cuadro"><?=$title?></h3>
            <p class="bold"><?=$nombre_autor?></p>
            <p class="autor-datos"> (<?=$birthPlace_autor?> <?=$birthYear_autor?>, <?=$deathPlace_autor?> <?=$deathYear_autor?>) </p>
            <p class="autor-datos"><?=$material?></p>
        </div>
        <div class="txtdiv">
            <p><?=$descriptionIta?></p>
        </div>
        <div class="btndiv">
            <a href="immagine.php"><div id="esplora">
                <a href="immagine.php?id=<?=$imagen?>"><div class="button espl-btn">ESPLORA L'IMMAGINE</div></a> 
              </div>
            </a>  
        </div>
    </section>

    <div class="footer">
        <div class="handicap open_handicap">
            <img id="chair" src="img/handic.png" alt="handicap">
        </div>
        <div id="add-div" class="hiding">
            <div class="handicap_shortcuts">
               
            </div> 
         
               
           
            <div class="down-cross">
            <img id="video" class="down-video open_video" src="img/videoicon.png">
                <a href="home.php"><img class="down-cross-size" src="img/cross.png" alt="go back">
            </div>
        </div>
    </div>

<script>

$(document).ready(function(){

$(document).on('click','.handicap',function(){
    $('#add-div').toggleClass('hiding');      
});

});

</script>

</body>
</html>