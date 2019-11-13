<?php require_once "templates/head.php"; ?>
<body>
<div class="background">
<?php require_once "templates/navbar.php"; ?>
    <div class="breadcrumbs">
        <p><span>i cartoni cinquecenteschi</span> / collezione</p>
    </div>
    <div id="bigcontainer">
        <div class="leftarrow" ><img src="img/left_arrow.png" alt="go left"></div>
        <div id="gallery">
            <div id="flexcont">
                <?php 
                    $consulta_cuadros = 
                    "SELECT 
                        painting.id,
                        painting.title,
                        painting.panoUrl,
                        painting.imageUrl,
                        author.name,
                        author.birthYear,
                        author.deathYear,
                        author.birthPlace,
                        author.deathPlace 
                    FROM painting
                    INNER JOIN 
                        author ON painting.author_id = author.id";
                    
                    $exec_cuadros = $conn -> prepare($consulta_cuadros);
                    $exec_cuadros -> execute();
                    $resultado = $exec_cuadros->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($resultado as $key){
                        $fecha = '('.$key['birthPlace'].' '.$key['birthYear'].', '.$key['deathPlace'].' '.$key['deathYear'].')';
                ?>
                    <div class="frame">
                        <img src="pinturas/<?=$key['panoUrl'].'/'.$key['imageUrl']?>">
                        <a href="immagine.php?id=<?php echo $key['id']; ?>">
                            <div class="layer">
                                <p class="layer-nombre"><?php echo $key['title']?></p>
                                <p class="layer-autor"><?=$key['name']?></p>
                                <p class="layer-fecha"><?=$fecha?></p>
                            </div>
                        </a>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="rightarrow">
            <img src="img/right_arrow.png" alt="right arrow">
        </div>
    </div>
    <div class="footer">
        <div><img id="chair" src="img/handic.png" alt="handicap"></div>
        <div id="add-div" class="hiding">
            <img src="img/toleft.png">   
            <img src="img/tobottom.png">  
            <img src="img/totop.png">   
            <img src="img/toright.png">    
        </div>
    </div>
</div>
</body>
<script src="scripts/galeria.js"></script>
<script src="scripts/home.js"></script>
</html>