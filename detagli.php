<?php 
  require_once "templates/head.php";
  $imagen = $_GET['id'];

  $exec_imagen = $conn->prepare("SELECT * FROM cartones WHERE id = :imagen");
  $exec_imagen->bindParam(':imagen',$imagen);
  $exec_imagen->execute();
  $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
  $title = $resultado['title'];
  $img = $resultado['imageUrl'];
  $img_sobreposada = $resultado['imageUrl_sobreposada'];

?>

<body>


<div class="background">

  <?php require_once "templates/navbar.php"; ?>

  <div class="breadcrumbs">
    <p><a href="immagine.php?id=<?=$imagen?>"><?=$title?></a> / <span class="bread2">esplora il disegno</span></p>
    <a class="close_breadcrumbs" href="immagine.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
  </div>

  <section class="contents">
    
  
    <div class="instrucciones activo">
      <div class="instrucciones_content">
        <div class="instrucciones_icon">
          <img src="img/brighticon.png">
        </div>
        <div class="instrucciones_texto">
            <h3>esplora il disegno</h3>
            <p>aumenta e riduci il contrasto dell'immagine per vedere meglio i dettagli</p>
        </div>
        <div class="instrucciones_boton">
          OK
        </div>
      </div>
    </div>


    <div id="imgcont"></div>

    <div class="percent">
        <img src="img/minbr.png" alt="down" id="brless">
        <div id="progressarea">
            <input type="range" id="bright" min="0" max="1" class="slider" step="0.1" value="1">
        </div>
        <img src="img/maxbr.png" alt="up" id="brmore">
    </div>

    <div class="iconsrow">
        <a href="mappa.php?id=<?=$imagen?>">
            <div class="fondo-icona">
                <img id="mapa" src="img/mapicon.png" alt="mapa">
            </div>
        </a>
        <a href="detagli.php?id=<?=$imagen?>">
            <div class="fondo-icona activo">
                <img id="detalle" src="img/brighticon.png" alt="detalle">
            </div>
        </a>
        <a href="tags.php?id=<?=$imagen?>">
            <div class="fondo-icona">
                <img id="tags" src="img/infoicon.png" alt="tags">
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
        <div class="instrucciones_ok activo">
          <div class="instrucciones_boton">OK</div>
        </div>
      </div>
      <div class="down-cross size-cross"><a href="immagine.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
      </div>
    </div>
  </div>

</div>

<script src="scripts/principal.js"></script>
<script>

var map, layer1, layer2;

$(document).ready(function(){
  
  /***********/
  /* Leaflet */
  /***********/

  map = L.map('imgcont', {
    minZoom: 2,
    maxZoom: 8,
    center: [0, 0],
    zoom: 4,
    zoomDelta: 1,
    crs: L.CRS.Simple,
    attributionControl:false,
    zoomControl: false,
    touchZoom: true,
    bounceAtZoomLimits: true
  });

  var img = new Image();
  var w, h;
  var url = 'pinturas/<?=$img?>',
      url2 = 'pinturas/<?=$img_sobreposada?>';

  img.src = url;
  
  img.addEventListener("load", function(){
    w = img.naturalWidth;
    h = img.naturalHeight;
    var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
    var southWest = map.unproject([0, h], map.getMaxZoom()-1);
    var bounds = new L.LatLngBounds(southWest, northEast);
    layer2 = L.imageOverlay(url2, bounds).addTo(map);
    layer1 = L.imageOverlay(url, bounds, {className: 'imatge_principal'}).addTo(map); 
    map.setMaxBounds(bounds);
  });

  //Cambiar la opacidad de la capa principal cuando se toca el slider del brillo
  $('#bright').on('change',function(){
    $('.imatge_principal').css('opacity',this.value)
  });

  $(document).on('click','.handicap',function(){
    $('#add-div').toggleClass('hiding');      
});

});

</script>

</body>
</html>