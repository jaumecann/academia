<?php 
    require_once "templates/head.php";
?>

<body>

<div class="background">

    <nav>
        <div class="lang">
        <a href=# class="bold" style="margin-right:10px">IT</a> | <a href=# style="margin-left:10px">EN</a>
        </div>

        <div style="color:white"><img src="img/lupa.png" alt="lupa"></div>
        <div style="color:white"><img src="img/home.png" alt="home"></div>

    </nav>
    <div class="breadcrumbs">
        <p><span>i cartoni cinquecenteschi</span> / collezione</p>
        <img src="img/cross.png" alt="cross">
    </div>

    <section class="contents">

        <div id="imgcont">
            <img id="imgid" src="img/pieta.png">
        </div> <!-- end img container-->

        <div class="percent">
            <img src="img/less.png" alt="down" id="less">
            <div id="progressarea"><p>xx%</p></div>
            <!--<input type="range" id="bright" min="0" max="100" value="">-->
            <img src="img/more.png" id="more" alt="up">
        </div> <!-- en bar row-->

        <div class="iconsrow">
            <img id="mapa" src="img/mapicon.png" alt="mapa">
            <img id="brightness" src="img/brighticon.png" alt="brightness">
            <img id="infopoints" src="img/infoicon.png" alt="info">

        </div> <!-- end icons row -->

    </section>
    



    <div class="footer">
        <img src="img/handic.png" alt="handicap">
       </div>

</div>


</body>

<script src="scripts/immagine.js"></script>
</html>