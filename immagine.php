<?php 
  require_once "templates/head.php";
  $imagen = $_GET['id'];

  $exec_imagen = $conn->prepare("SELECT * FROM painting WHERE id = :imagen");
  $exec_imagen->bindParam(':imagen',$imagen);
  $exec_imagen->execute();
  $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
  $img = $resultado['imageUrl'];
  $panoUrl = $resultado['panoUrl'];
?>

<body>

<div class="background">

  <?php require_once "templates/navbar.php"; ?>

  <div class="breadcrumbs">
    <p><span>i cartoni cinquecenteschi</span> / collezione</p>
    <img src="img/cross.png" alt="cross">
  </div>

  <section class="contents">

    <div id="imgcont"></div>

    <div class="percent">
      <img onclick="zoomImg('out')" id="minus" src="img/less.png" alt="down" id="less">
      <div id="progressarea">
        <span id="image-opacity">1</span>
        <input type="range" id="bright" min="0" max="1" class="slider" step="0.1" value="1">
      </div>
      <img onclick="zoomImg('in')" id="plus" src="img/more.png" id="more" alt="up">
    </div>

    <div class="iconsrow">
      <img id="mapa" src="img/mapicon.png" alt="mapa">
      <img onclick="openBrightness()" id="brightness" src="img/brighticon.png" alt="brightness">
      <img onclick="showInfoPoints()" id="infopoints" src="img/infoicon.png" alt="info">
    </div>
  </section>

  <?php require_once "templates/footer.php"; ?>
</div>


<script>

/* Hacemos que los tags se cargan siempre, pero al principio no se muestran.
Luego pulsando el boton de tags se 'cargan', en realidad ya estaban allí, solo que ahora
los mostramos dandole una clase */

/* Mostrar los tags quando se pulsa el boton de tags */
function showInfoPoints(){
  console.log("Mostrar tags");
  $('.leaflet-popup-pane').fadeToggle();
  $('.leaflet-marker-pane').fadeToggle();
}

/* Hacer zoom al pulsar botones externos a la libreria */
function zoomImg(direccion){
  if(direccion == 'in'){
    map.zoomIn();
  }else if(direccion == 'out'){
    map.zoomOut();
  }else{ 
    console.log('No se esta pasando una direccion correcta en el zoom! ') 
  }
}

/* Abrir la barra controladora de brillo */
function openBrightness(){
  $('#progressarea').toggleClass('show');
}



/* Todo lo de creacion del mapa Leaflet*/

// Using leaflet.js to pan and zoom a big image.
// See also: http://kempe.net/blog/2014/06/14/leaflet-pan-zoom-image.html
// create the slippy map
var map = L.map('imgcont', {
  minZoom: 1,
  maxZoom: 4,
  center: [0, 0],
  zoom: 2,
  zoomDelta: 1,
  crs: L.CRS.Simple,
  attributionControl:false,
  zoomControl: false,
  touchZoom: true,
  bounceAtZoomLimits: true
});

// dimensions of the image
var w = 2000,
    h = 2000,
    url = 'pinturas/<?=$img?>';

// calculate the edges of the image, in coordinate space
var southWest = map.unproject([0, h], map.getMaxZoom()-1);
var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
var bounds = new L.LatLngBounds(southWest, northEast);

// add the image overlay, 
// so that it covers the entire map
var layer1 = L.imageOverlay(url, bounds).addTo(map);
var layer2 = L.imageOverlay('pinturas/<?=$img?>', bounds,).addTo(map);
// tell leaflet that the map is exactly as big as the image
map.setMaxBounds(bounds);

var myIcon = L.icon({
  iconUrl: 'img/infopoint.png',
  iconSize:     [35, 35], // size of the icon
  iconAnchor:   [15, 15], // point of the icon which will correspond to marker's location
  popupAnchor:  [75, 40] // point from which the popup should open relative to the iconAnchor
});

L.marker([-18.5, 25.09], {icon:myIcon}).addTo(map).bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();

L.DomEvent.on(L.DomUtil.get('bright'), 'change', function () {
  L.DomUtil.get('image-opacity').textContent = this.value;
  //layer2.options.opacity = this.value;
  layer2.setOpacity(this.value);
});

</script>
</body>
</html>