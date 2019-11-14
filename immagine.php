<?php 
  require_once "templates/head.php";
  $imagen = $_GET['id'];

  $exec_imagen = $conn->prepare("SELECT * FROM painting WHERE id = :imagen");
  $exec_imagen->bindParam(':imagen',$imagen);
  $exec_imagen->execute();
  $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
  $img = $resultado['imageUrl'];
  $img_sobreposada = $resultado['imageUrl_sobreposada'];
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
      <div class="fondo-icona"><img id="mapa" src="img/mapicon.png" alt="mapa"></div>
      <div class="fondo-icona"><img onclick="openBrightness()" id="brightness" src="img/brighticon.png" alt="brightness">
    </div>
      <div class="fondo-icona"><img onclick="showInfoPoints()" id="infopoints" src="img/infoicon.png" alt="info">
    </div>
    </div>
  </section>

  <?php require_once "templates/footer.php"; ?>
</div>


<script>

/* Hacemos que los tags se cargan siempre, pero al principio no se muestran.
Luego pulsando el boton de tags se 'cargan', en realidad ya estaban allí, solo que ahora
los mostramos dandole una clase */

/* Mostrar los tags quando se pulsa el boton de tags */



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
/* Amb variables i condicionals per canviar icones */


var minbr = "<img src=\"img/minbr.png\" alt=\"down\" id=\"brless\">";
var maxbr = "<img src=\"img/maxbr.png\" alt=\"up\" id=\"brmore\">";
var minlupa = "<img src=\"img/less.png\" alt=\"down\" id=\"minus\">";
var maxlupa = "<img src=\"img/more.png\" alt=\"down\" id=\"plus\">";

if ($("#infopoints").hasClass("change-style")){
  $(this).data('clicked', true);
}

if ($("#brightness").hasClass("change-style")){
  $(this).data('clicked', true);
}

function openBrightness(){

  $('#progressarea').toggleClass('show');

  if ($("#brightness").hasClass("change-style")){
    $("#brless").replaceWith(minlupa);
    $("#brmore").replaceWith(maxlupa);
      
    } else {
    $("#minus").replaceWith(minbr);
    $("#plus").replaceWith(maxbr);
        
    }

};



/* Todo lo de creacion del mapa Leaflet*/

// Using leaflet.js to pan and zoom a big image.
// See also: http://kempe.net/blog/2014/06/14/leaflet-pan-zoom-image.html
// create the slippy map
var map = L.map('imgcont', {
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

// dimensions of the image

var w = 500,
    h = 500,
    url = 'pinturas/<?=$img?>';


// calculate the edges of the image, in coordinate space
var southWest = map.unproject([0, h], map.getMaxZoom()-1);
var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
var bounds = new L.LatLngBounds(southWest, northEast);





// add the image overlay, 
// so that it covers the entire map
url2 = 'pinturas/<?=$img_sobreposada?>';

var layer1 = L.imageOverlay(url, bounds).addTo(map);
var layer2 = L.imageOverlay(url2, bounds).addTo(map);




// tell leaflet that the map is exactly as big as the image
map.setMaxBounds(bounds);

var myIcon = L.icon({
  iconUrl: 'img/infopoint.png',
  iconSize:     [35, 35], // size of the icon
  iconAnchor:   [15, 15], // point of the icon which will correspond to marker's location
  popupAnchor:  [70, 60] // point from which the popup should open relative to the iconAnchor
});

L.marker([-18.5, 25.09], {icon:myIcon}).addTo(map).bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();

$(".leaflet-popup").hide();
  $(".leaflet-marker-icon").hide();

  var toggleIt = true;

function showInfoPoints(){
  console.log("Mostrar tags");

if(toggleIt){
  $('.leaflet-popup').show();
  $('.leaflet-marker-icon').show();
  toggleIt = false;
} else {
  $('.leaflet-popup').hide();
  $('.leaflet-marker-icon').hide();
  toggleIt= true;
}  

};


L.DomEvent.on(L.DomUtil.get('bright'), 'change', function () {
  L.DomUtil.get('bright').value = this.value;
  //layer2.options.opacity = this.value;
  layer2.setOpacity(this.value);
});

$("#brightness, #infopoints").click(function(){
  $(this).toggleClass("change-style");
})


var cuadro_x = document.getElementsByTagName('img')[2].naturalWidth;
var cuadro_y = document.getElementsByTagName('img')[2].naturalHeight;

var cuadro_x2 = document.getElementsByTagName('img')[3].naturalWidth;
var cuadro_y2 = document.getElementsByTagName('img')[3].naturalHeight;

console.log(cuadro_x);

//reassignem valor a les imatges un cop carregada la finestra amb les dimensions reals de les fotos;

window.onload = function (){
  w = cuadro_x;
  h = cuadro_y;
  w2 = cuadro_x2;
  h2 = cuadro_y2;

southWest = map.unproject([0, h], map.getMaxZoom()-1);
northEast = map.unproject([w, 0], map.getMaxZoom()-1);
southWest2 = map.unproject([0, h2], map.getMaxZoom()-1);
northEast2 = map.unproject([w2, 0], map.getMaxZoom()-1);

bounds = new L.LatLngBounds(southWest, northEast);
bounds2 = new L.LatLngBounds(southWest2, northEast2);

layer1 = L.imageOverlay(url, bounds).addTo(map);
layer2 = L.imageOverlay(url2, bounds2).addTo(map);
map.setMaxBounds(bounds2);
};




</script>

</body>
</html>