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
        <a href="cartone.php"><img src="img/cross.png" alt="cross"></a>
    </div>

    <section class="contents">

        
        <div class="box1">
            <p>Scheda tecnica del cartone</p>

            <div class="minicartone">
                <div class="boximg">
                            <img src="pinturas/pieta.png">
                        </div>
                    <div class="txtscheda">
                            <h4>Pietà per Vittoria Colonna </h4>
                            <p class="bold">Michelangelo Buonarroti</p>
                            <p>(Valduggia 1475ca, Milano 1546)</p>
                            <p>Carboncino, matita nera e gessetto su carta.</p>
                        </div>        
            </div>
        </div>

        <div class="box2">
            <p>Mappa delle riproduzioni in Europa</p>

            <div id="mapframe">
                <div class="region">
                <img src="img/mappa.png" alt="europe map">
                </div>

                
            

            <div class="whitebox display-onclick">
                <div class="boximg">
                    <img src="pinturas/imgcolor.png">
                </div>
                   
                <div class="txtwhite">
                    <h5>Pietà per Vittoria Colonna </h5>
                    <p><span class="bold">Michelangelo Buonarroti</span><br>
                    (Valduggia 1475ca, Milano 1546)<br>
                    <p>Carboncino, matita nera e gessetto su carta.</p>
                 </div> <!-- end txtwhite -->
                    
                    <div class="blackx">
                        <img src="img/crossblack.png" alt="chiudi">
                    </div> 

            </div> <!--end whitebox-->

        
                    
                <div class="spot">
                <img src="img/location.png" alt="location tag">      </div>

                
              
              
            </div><!-- end mapframe-->

        </div> <!--end box2-->



   
      
     <div class="iconsrow">
      <div class="change-style"><img id="mapa" src="img/mapicon.png" alt="mapa"></div>
      <a href="immagine.php"><div class="fondo-icona"><img onclick="openBrightness()" id="brightness" src="img/brighticon.png" alt="brightness">
      </div></a>
      <a href="immagine.php"><div class="fondo-icona"><img onclick="showInfoPoints()" id="infopoints" src="img/infoicon.png" alt="info">
      </div></a>
     </div> <!-- end icons row -->
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

 $(".spot").click(function(){
    $(".whitebox").css("left", copyleft - 35 + "px");
 })
 .click(function(){
    $(".whitebox").css("top", copytop -130 + "px");
 })
 .click(function(){
    $(".whitebox").toggleClass("display-onclick");
 })

 $(".blackx").click(function(){
    $(".whitebox").toggleClass("display-onclick");
 })


</script>

</body>
</html>