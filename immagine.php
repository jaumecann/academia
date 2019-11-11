<?php 
    require_once "templates/head.php";
?>

<body>

<div class="background">

<?php 
    require_once "templates/navbar.php";
?>

    <div class="breadcrumbs">
        <p><span>i cartoni cinquecenteschi</span> / collezione</p>
        <img src="img/cross.png" alt="cross">
    </div>

    <section class="contents">

        <div id="imgcont">
            <img id="imgid" src="img/pieta.png">
        </div> <!-- end img container-->

        <div class="percent">
        <div id="lessbox">
            <img src="img/less.png" alt="down" id="less">
            </div>
            <div id="progressarea"><p>xxx%</p></div>
            <!--<input type="range" id="bright" min="0" max="100" value="">-->
            <div id="morebox">
            <img src="img/more.png" id="more" alt="up">
            </div>
        </div> <!-- en bar row-->

        <div class="iconsrow">
        <a href="mappa.php"><img id="mapa" src="img/mapicon.png" alt="mapa"></a>
        <img id="brightness" src="img/brighticon.png" alt="brightness">
        <a href="tagspage.php"><img id="infopoints" src="img/infoicon.png" alt="info"></a>

        </div> <!-- end icons row -->

    </section>

    <?php 
    require_once "templates/footer.php";
?>
    
</div>


 


</body>

<script src="scripts/immagine.js"></script>
</html>