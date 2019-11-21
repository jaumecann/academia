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
        <a href="cartone.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
    </div>

    <section class="contents">
        <div class="box1">
            <p class="box1-titl">Scheda tecnica del cartone</p>
            <div class="minicartone">
                <div class="boximg">
                    <img src="pinturas/<?=$img?>">
                </div>
                <div class="txtscheda">
                    <h4><?=$title?></h4>
                    <p class="bold"><?=$nombre_autor?></p>
                    <p>(<?=$birthPlace_autor?> <?=$birthYear_autor?>, <?=$deathPlace_autor?> <?=$deathYear_autor?>)</p>
                    <p><?=$material?></p>
                </div>        
            </div>
        </div>

        <div class="box2">
            <p>Mappa delle riproduzioni in Europa</p>

            <div id="mapframe">
                <div class="region">
                    <img src="img/mappa.png" alt="europe map">
                </div>


                <div class="spot">
                    <img src="img/location.png" alt="location tag">      
                </div>

                <div class="whitebox display-onclick">
                    <div class="compared-img-box">
                        <div class="img1-overwhite">   
                          <img src="pinturas/<?=$img?>">  
                        </div>
                        <div class="img1-overwhite">
                          <img src="pinturas/<?=$img?>">
                        </div>
                    </div>
                    
                   
                    <div class="txtwhite">
                        <h5><?=$title?></h5>
                        <p><span class="bold"><?=$nombre_autor?></span><br>
                        (<?=$birthPlace_autor?> <?=$birthYear_autor?>, <?=$deathPlace_autor?> <?=$deathYear_autor?>)<br>
                        <p><?=$material?></p>
                    </div>
                    
                    <div class="blackx">
                        <img src="img/crossblack.png" alt="chiudi">
                    </div>
            </div>

            </div>




        </div>

    <div class="iconsrow">
        <div class="change-style">
            <img id="mapa" src="img/mapicon.png" alt="mapa">
        </div>
        <a href="immagine.php?id=<?=$imagen?>">
            <div class="fondo-icona">
                <img onclick="openBrightness()" id="brightness" src="img/brighticon.png" alt="brightness">
            </div>
        </a>
        <a href="immagine.php?id=<?=$imagen?>">
            <div class="fondo-icona">
                <img onclick="showInfoPoints()" id="infopoints" src="img/infoicon.png" alt="info">
            </div>
        </a>
    </div>
</section>

<?php 
    require_once "templates/footer.php";
?>

</div>

<script>

 var copyleft = parseInt($(".spot").css("left"));
 console.log(copyleft);
 var copytop = parseInt($(".spot").css("top"));    
 console.log(copytop); 

console.log("HOla")
/*
 $(".spot").click(function(){
  //$(".whitebox").css("left", copyleft - 35 + "px");
  $(".whitebox").css("margin", "auto");
 })
 .click(function(){
   //$(".whitebox").css("top", copytop -130 + "px");
    $(".whitebox").css("bottom", "30px");
 })
 */
 
 $(".spot").click(function(){
    $(".whitebox").toggleClass("display-onclick");
 })

 $(".blackx").click(function(){
    $(".whitebox").toggleClass("display-onclick");
 })


</script>

</body>
</html>