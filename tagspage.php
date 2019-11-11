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

        <div class="imgcont">
            <img id="imgid" src="img/pieta.png">
            
            <div class="red-area">
                <div class="red-i"><img src="img/infopoint.png"></div>
            
                <div class="redbox"> 
                <p>In alto si leva una trave, la Croce, dove si legge, in verticale, una citazione di Dante: “Non vi si pensa quanto sangue costa”</p>
                </div>

            </div> <!-- end  -->

<!-- punt info sense seleccionar. Té la classe i-point -->

            <div class="i-point" ><img src="img/infopoint.png"></div>

        </div> <!-- end img container-->

        <div class="percent">
            <img src="img/less.png" alt="down" id="less">
            <div id="progressarea"><p>xxx%</p></div>
            <!--<input type="range" id="bright" min="0" max="100" value="">-->
            <img src="img/more.png" id="more" alt="up">
        </div> <!-- en bar row-->

        <div class="iconsrow">
            <img id="mapa" src="img/mapicon.png" alt="mapa">
            <img id="brightness" src="img/brighticon.png" alt="brightness">
            <img id="infopoints" src="img/infogr.png" alt="info">

        </div> <!-- end icons row -->

    </section>

    <?php 
    require_once "templates/footer.php";
?>


    
</div>


 


</body>

<script src="scripts/tagspage.js"></script>

</html>