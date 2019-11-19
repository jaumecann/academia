<?php 
    require_once "templates/head.php";
    $imagen = $_GET['id'];

    $exec_imagen = $conn->prepare("SELECT * FROM painting INNER JOIN author ON painting.author_id = author.id WHERE painting.id = :imagen");
    $exec_imagen->bindParam(':imagen',$imagen);
    $exec_imagen->execute();
    $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
    $img = $resultado['imageUrl'];
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
        <p><a href="home.php">Home</a> / <?=$title?></p>
        <a href="home.php"><img src="img/back.png" alt="go back">
    </div></a>

    <section id="cartone">
        <div class="imgdiv"><img src="pinturas/<?=$img?>"></div>
        <div class="bigtxtdiv">
            <h3><?=$title?></h3>
            <p class="bold"><?=$nombre_autor?></p>
            <p> (<?=$birthPlace_autor?> <?=$birthYear_autor?>, <?=$deathPlace_autor?> <?=$deathYear_autor?>) </p>
            <p><?=$material?></p>
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



    <?php 
    require_once "templates/footer.php";
?>



</body>
</html>