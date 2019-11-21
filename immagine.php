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

  $get_tags = $conn->prepare("SELECT * FROM detail WHERE painting_id = :painting_id");
  $get_tags->bindParam(':painting_id', $imagen);
  $get_tags->execute();
  $resultado_tags = $get_tags->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="handicap open_handicap">
      <img id="chair" src="img/handic.png" alt="handicap">
    </div>
    <div id="add-div" class="hiding">
      <div class="handicap_shortcuts">
        <?php
        foreach($resultado_tags as $key=>$tag){
        ?>
          <div id="handicap_tag_<?=$key?>" class="handicap_tag"><?=$key?></div>
        <?php } ?>
      </div>
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

if($("#infopoints").hasClass("change-style")){
  $(this).data('clicked', true);
}

if($("#brightness").hasClass("change-style")){
  $(this).data('clicked', true);
}

function openBrightness(){
  if($("#brightness").hasClass("change-style")){
    $("#brless").replaceWith(minlupa);
    $("#brmore").replaceWith(maxlupa);
    $('#progressarea').toggleClass('show');
    $("#brightness").toggleClass("change-style");
  }else{
    $("#minus").replaceWith(minbr);
    $("#plus").replaceWith(maxbr);
    $('#progressarea').toggleClass('show');
    $("#brightness").toggleClass("change-style");    
  }
};

// mostrar o amagar tags
var toggleIt = true;
function showInfoPoints(){
  console.log("Cambiar estado tags: "+toggleIt)
  if(toggleIt){
    $('.leaflet-marker-icon').show();
    $("#infopoints").toggleClass("change-style");
    toggleIt = false;
  }else{
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
  
  showInfoPoints();
  // Abrir el menú de minusválidos
  /* Lo hice sin toggle porque depende de como hace una cosa u otra, no es solo toggle */
  /* Ademas no me encuentro bien y no se me ocurre nada mejor sooo fuckit */
  $(document).on('click','.open_handicap',function(){
    $('.handicap').addClass('close_handicap');
    $('.handicap').removeClass('open_handicap');

    $('#add-div').removeClass('hiding');
    $('.frame').addClass('handicap_active');

    //Al pulsar el handicap, que se centre
    //Despues de 500ms, cuando le ha dado tiempo a cambiar, hace el collide
    centrar_scroll()
    setTimeout(() => {
        collide_cursorFrame();    
    }, 520);
      
  });
  $(document).on('click','.close_handicap',function(){
    $('.handicap').removeClass('close_handicap');
    $('.handicap').addClass('open_handicap');
    
    $('#add-div').addClass('hiding');
    $('.frame').removeClass('handicap_selected');
  })

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



  /******************/
  /* Leaflet + tags */
  /******************/

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

  //Definir el disseny dels tags
  var myIcon = L.icon({
    iconUrl: 'img/infopoint.png',
    iconSize:     [35, 35],
    iconAnchor:   [15, 15],
    popupAnchor:  [60, 55]
  });

  //Executem per ajax el doc get_image_tags.php que fa la consulta dels tags i ens retorna el resultat aquí
  $.ajax({
    url: 'php/get_image_tags.php',
    data: {
      image_id: <?=$_GET['id']?>,
    },
    dataType: 'json',
    method: 'post',
    success:function(resp){
      resp.forEach( (tag,index) => {
        var marker = L.marker([tag.x, tag.y],{
          icon: myIcon
        }).addTo(map);
        var popup = L.popup().setContent('<p>'+tag.desc+'</p>');
        marker.bindPopup(popup);
      });
    }
  });

});

</script>

</body>
</html>