<?php 
  require_once "templates/head.php";
  $imagen = $_GET['id'];

  $exec_imagen = $conn->prepare("SELECT * FROM painting WHERE id = :imagen");
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
        <p><a href="home.php">i cartoni cinquecenteschi</a> / <?=$title?></p>
        <a href="cartone.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
    </div>

  <section class="contents">

    <div id="imgcont"></div>

    <div class="percent">
      <img onclick="zoomImg('out')" id="minus" src="img/less.png" alt="down" id="less">
      <div id="progressarea">
        <input type="range" id="bright" min="0" max="1" class="slider" step="0.1" value="1">
      </div>
      <img onclick="zoomImg('in')" id="plus" src="img/more.png" id="more" alt="up">
    </div>

    <div class="iconsrow">
      <a href="mappa.php?id=<?=$imagen?>"><div class="fondo-icona"><img id="mapa" src="img/mapicon.png" alt="mapa"></div></a>
      <div class="fondo-icona"><img onclick="openBrightness()" id="brightness" src="img/brighticon.png" alt="brightness">
    </div>
      <div class="fondo-icona"><img onclick="showInfoPoints()" id="infopoints" src="img/infoicon.png" alt="info">
    </div>
    </div>
  </section>

  <div class="footer">
        <div><img id="chair" src="img/handic.png" alt="handicap"></div>

        <div id="add-div" class="hiding">
            <img class="newbtn" src="img/infopoint.png">   
            <img class="newbtn" src="img/infopoint.png">  
            <img class="newbtn" src="img/infopoint.png">   
            <img class="newbtn" src="img/infopoint.png">    
        </div>
</div>

</div>

<script>

var map, layer1, layer2;

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

/* Abrir la barra controladora de brillo */
/* Amb variables i condicionals per canviar icones */
var minbr = "<img src=\"img/minbr.png\" alt=\"down\" id=\"brless\">";
var maxbr = "<img src=\"img/maxbr.png\" alt=\"up\" id=\"brmore\">";
var minlupa = "<img onclick=\"zoomImg('out')\" src=\"img/less.png\" alt=\"down\" id=\"minus\">";
var maxlupa = "<img src=\"img/more.png\" onclick=\"zoomImg('in')\" alt=\"down\" id=\"plus\">";

if ($("#infopoints").hasClass("change-style")){
  $(this).data('clicked', true);
}

if ($("#brightness").hasClass("change-style")){
  $(this).data('clicked', true);
}

function openBrightness(){
  if ($("#brightness").hasClass("change-style")){
    $("#brless").replaceWith(minlupa);
    $("#brmore").replaceWith(maxlupa);
    $('#progressarea').toggleClass('show');
    $("#brightness").toggleClass("change-style");
  } else {
    $("#minus").replaceWith(minbr);
    $("#plus").replaceWith(maxbr);
    $('#progressarea').toggleClass('show');
    $("#brightness").toggleClass("change-style");    
  }
};

// mostrar o amagar tags
var toggleIt = true;
function showInfoPoints(){
  console.log("Mostrar tags");
  /*$('.leaflet-marker-pane').fadeToggle();
  $('.leaflet-popup-pane').fadeToggle();*/

  if(toggleIt){ 
    $('.leaflet-marker-icon').show();
    $("#infopoints").toggleClass("change-style");
    toggleIt = false;
  } else {
    $('.leaflet-popup').hide();
    $('.leaflet-marker-icon').hide();
    $("#infopoints").toggleClass("change-style"); 
    if ($("#add-div").is(":visible")){
      $("#add-div").toggleClass("hiding");
    };
    toggleIt= true;
  }  
};


$(document).ready(function(){
  //Al principi, amaga els tags i els popups
  $(".leaflet-popup").hide();
  $(".leaflet-marker-icon").hide();
  
  //Obre el menu de minusvalids
  $("#chair").click(function(){
    if ($("#infopoints").hasClass("change-style")){
      $("#add-div").toggleClass("hiding");
    } 
  }); 

  $(".leaflet-marker-icon").click(function(){
    $('.leaflet-popup').show();
  });

  // tornar a l'estat inicial si es clica l'altre botó
  $("#brightness").click(function(){
    if (toggleIt==false){
      showInfoPoints();
    }
  });
  $("#infopoints").click(function(){
    if ($("#brightness").hasClass("change-style")){
      openBrightness(); 
    }
    map.setZoom(4);
    $('.imatge_principal').css('opacity',1)
    $("#bright").val(1);
  });



  /*********************************/
  /* Tags i funcionament dels tags */
  /*********************************/

  /* Todo lo referente a las imagenes puestas con Leaflet*/

  // Using leaflet.js to pan and zoom a big image: http://kempe.net/blog/2014/06/14/leaflet-pan-zoom-image.html
  
  // Creamos el mapa base con todo lo que sea blabla facil
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

  // Creem un objecte d'imatge al que posarem la info de la imatge gorda, definim variables globals que necessitarem més endavant
  var img = new Image();
  var w, h;
  var url = 'pinturas/<?=$img?>',
      url2 = 'pinturas/<?=$img_sobreposada?>';

  // Li diem a l'objecte imatge que l'src ha de ser el definit a url
  console.log(img);
  img.src = url;
  
  // I només quan ha carregat la imatge fem tot lo de leaflet
  img.addEventListener("load", function(){

    // Com que ja tenim la imatge referida a img, veiem quines son les seves mides originals i les fem servir despres en comptes del 500,500 per defecte que teniem abans
    w = img.naturalWidth;
    h = img.naturalHeight;

    // Aquí el que fem és agafar les coordenades dels vertex de la imatge
    // El mapa considera per defecte que el vertex nordOest es 0,0
    // Aleshores definim que el vertex sudOest ha d'estar a 0,2000(w definida abans)
    // I el nordest a 2000,0(la h)
    // el map.getMaxZoom()-1 crec que es per dir-li que aquestes mides han de ser així considerant que el zoom és, en aquet cas, 7 (tenim un maxZoom de 8 - 1). No crec que sigui del tot correcte pero funciona tot be sembla
    var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
    var southWest = map.unproject([0, h], map.getMaxZoom()-1);
    // Definim l'objecte aquet de leaflet que guarda una Latitud i longitud donant-li les coordenades d'abans
    var bounds = new L.LatLngBounds(southWest, northEast);
    // Posem les imatges sobre el mapa, amb la mida que s'ha definit abans a bounds
    // Primer posem la sobreposada, perquè quedi per sota
    // I a la principal li afegim una classe per poder-la agafar sempre sense fer coses rares (a les opcions de imageOverlay hi ha className per donar-li una classe a la imatge)
    layer2 = L.imageOverlay(url2, bounds).addTo(map);
    layer1 = L.imageOverlay(url, bounds, {className: 'imatge_principal'}).addTo(map);
    // I definim les noves mides del mapa, que han de ser les que hem guardat abans a bounds i coincideixen evidentment amb les imatges perque ho estem posant tot a partir de bounds
    map.setMaxBounds(bounds);

  });

  //Cambiar la opacidad de la capa principal cuando se toca el slider del brillo
  // Esto esta muy bien que se pueda hacer con la libreria
  /*L.DomEvent.on(L.DomUtil.get('bright'), 'change', function () {
    L.DomUtil.get('bright').value = this.value;
    layer1.setOpacity(this.value);
  });*/
  //Pero coño mejor javascript o jquery que es lo mismo, sabemos como va sin tener que mirar documentaciones y ademas es mas facil
  $('#bright').on('change',function(){
    $('.imatge_principal').css('opacity',this.value)
  });


  //Definir el disseny dels tags
  var myIcon = L.icon({
    iconUrl: 'img/infopoint.png',
    iconSize:     [35, 35], // size of the icon
    iconAnchor:   [15, 15], // point of the icon which will correspond to marker's location
    popupAnchor:  [75, 65] // point from which the popup should open relative to the iconAnchor
  });

  //Executem per ajax el doc get_image_tags.php que fa la consulta dels tags i ens retorna el resultat aquí
  $.ajax({
    url: 'php/get_image_tags.php',
    data: {
      image_id: <?=$_GET['id']?>,
    },
    dataType: 'json',
    method: 'post',
    beforeSend: function(res){
      console.log( "Buscar tags de la imatge " + <?=$_GET['id']?> )
    },
    success:function(resp){
      //Nos devuelve un array con los tags y la info
      console.log(resp);
      resp.forEach( (tag,index) => {
        var marker = L.marker([tag.x, tag.y]).addTo(map);
        var popup = L.popup().setContent('<p>'+tag.desc+'</p>');
        marker.bindPopup(popup).openPopup();
      });
    }
  });

}); //Final del document.ready


</script>

</body>
</html>