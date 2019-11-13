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
            <img src="img/less.png" alt="down" id="less">
            <div id="progressarea"><p>xxx%</p></div>
            <!--<input type="range" id="bright" min="0" max="100" value="">-->
            <img src="img/more.png" id="more" alt="up">
        </div> <!-- en bar row-->

        <div class="iconsrow">
            <img id="mapa" src="img/mapicon.png" alt="mapa">
            <img id="brightness" src="img/brighticon.png" alt="brightness">
            <img id="infopoints" src="img/infoicon.png" alt="info">

        </div> <!-- end icons row -->

    </section>

    <?php 
    require_once "templates/footer.php";
?>
    
</div>

<script>

// Using leaflet.js to pan and zoom a big image.
// See also: http://kempe.net/blog/2014/06/14/leaflet-pan-zoom-image.html
// create the slippy map
var map = L.map('imgcont', {
  minZoom: 1,
  maxZoom: 4,
  center: [0, 0],
  zoom: 2,
  crs: L.CRS.Simple,
  attributionControl:false,
  zoomControl: false,

});

// dimensions of the image
var w = 1000,
    h = 1000,
    url = 'https://www.arthipo.com/image/cache/catalog/artists-painters/r/rene-magritte/rm137-rene-magritte-portrait-of-stephy-langui-1000x1000.jpg';
// calculate the edges of the image, in coordinate space
var southWest = map.unproject([0, h], map.getMaxZoom()-1);
var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
var bounds = new L.LatLngBounds(southWest, northEast);
// add the image overlay, 
// so that it covers the entire map
var layer1 = L.imageOverlay(url, bounds).addTo(map);
var layer2 = L.imageOverlay('https://www.arthipo.com/image/cache/catalog/artists-painters/a/alberto-pasini/apsn25-Alberto-Pasini-Oriental-landscape-with-Mosque-1000x1000.jpg', bounds,).addTo(map);
// tell leaflet that the map is exactly as big as the image
map.setMaxBounds(bounds);

var myIcon = L.icon({
iconUrl: 'https://raw.githubusercontent.com/jaumecann/academia/master/img/infopoint.png',

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

<script>

$(document).ready(function(){

$('#plus').click(function () {
  map.setZoom(map.getZoom()+1)
});
$('#minus').click(function () {
  map.setZoom(map.getZoom()-1)
});

});  
</script>

<script src="scripts/immagine.js"></script>

</body>

</html>