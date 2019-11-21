<?php 
  require_once "templates/head.php";
  $imagen = $_GET['id'];

  $exec_imagen = $conn->prepare("SELECT * FROM cartones WHERE id = :imagen");
  $exec_imagen->bindParam(':imagen',$imagen);
  $exec_imagen->execute();
  $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
  $title = $resultado['title'];
  $img = $resultado['imageUrl'];

?>

<body>


<div class="background">

  <?php require_once "templates/navbar.php"; ?>

  <div class="breadcrumbs">
    <p><a href="immagine.php?id=<?=$imagen?>"><?=$title?> / </p>
    <a href="cartone.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
  </div>

  <section class="contents">

    <div id="imgcont"></div>

    <div class="percent">
      <img onclick="zoomImg('out')" id="minus" src="img/less.png" alt="down" id="less">
      <img onclick="zoomImg('in')" id="plus" src="img/more.png" id="more" alt="up">
    </div>

    <div class="iconsrow">
        <a href="mappa.php?id=<?=$imagen?>">
            <div class="fondo-icona">
                <img id="mapa" src="img/mapicon.png" alt="mapa">
            </div>
        </a>
        <a href="detagli.php?id=<?=$imagen?>">
            <div class="fondo-icona">
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
        
      </div>
    </div>
  </div>

</div>

<script src="scripts/principal.js"></script>
<script>

var map, layer1;

/* Hacer zoom al pulsar botones externos */
function zoomImg(direccion){
  if(direccion == 'in'){
    map.zoomIn();
  }else if(direccion == 'out'){
    map.zoomOut();
  }else{ 
    console.log('No se esta pasando una direccion correcta en el zoom! ')
  }
}

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
  var url = 'pinturas/<?=$img?>';

  img.src = url;
  
  img.addEventListener("load", function(){
    w = img.naturalWidth;
    h = img.naturalHeight;
    var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
    var southWest = map.unproject([0, h], map.getMaxZoom()-1);
    var bounds = new L.LatLngBounds(southWest, northEast);
    layer1 = L.imageOverlay(url, bounds, {className: 'imatge_principal'}).addTo(map); 
    map.setMaxBounds(bounds);
  });

});

</script>

</body>
</html>