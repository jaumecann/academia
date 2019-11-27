<?php 
  require_once "templates/head.php";
  $carton = $_GET['id'];

  $exec_carton = $conn->prepare("SELECT * FROM cartones WHERE id = :carton");
  $exec_carton->bindParam(':carton',$carton);
  $exec_carton->execute();
  $resultado = $exec_carton -> fetch(PDO::FETCH_ASSOC);
  $title = $resultado['title'];
  $img = $resultado['imageUrl'];

  $get_tags = $conn->prepare("SELECT * FROM detail WHERE painting_id = :carton_id");
  $get_tags->bindParam(':carton_id', $carton);
  $get_tags->execute();
  $resultado_tags = $get_tags->fetchAll(PDO::FETCH_ASSOC);
?>

<body>


<div class="background">

  <?php require_once "templates/navbar.php"; ?>

  <div class="breadcrumbs">
  <p class="playfair"><a href="immagine.php?id=<?=$carton?>"><?=$title?></a> / <span class="bread2">esplora i detagli</span></p>
    <a class="close_breadcrumbs" href="immagine.php?id=<?=$carton?>"><img src="img/cross.png" alt="cross"></a>
  </div>

  <section class="contents">
    
  
    <div class="instrucciones activo">
      <div class="instrucciones_content">
        <div class="instrucciones_icon">
          <img src="img/infoicon.png">
        </div>
        <div class="instrucciones_texto">
            <p class="instrucciones_titl">esplora i dettagli</p>
            <p class="instrucciones_content">clicca sulla "i" per scoprire i dettagli del cartone</p>
        </div>
        <div class="instrucciones_boton">
          OK
        </div>
      </div>
    </div>


    <div id="imgcont"></div>

    <div class="percent">
      <img onclick="zoomImg('out')" id="minus" src="img/less.png" alt="down" id="less">
      <img onclick="zoomImg('in')" id="plus" src="img/more.png" id="more" alt="up">
    </div>

    <div class="iconsrow">
        <a href="mappa.php?id=<?=$carton?>">
            <div class="fondo-icona">
                <img id="mapa" src="img/mapicon.png" alt="mapa">
            </div>
        </a>
        <a href="detagli.php?id=<?=$carton?>">
            <div class="fondo-icona">
                <img id="detalle" src="img/brighticon.png" alt="detalle">
            </div>
        </a>
        <a href="tags.php?id=<?=$carton?>">
            <div class="fondo-icona activo">
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
                <div class="instrucciones_boton2">OK</div>
            </div>
            <div class="correspondencia_tags">
                <?php
                foreach($resultado_tags as $key=>$tag){
                    $tag_corr = $key + 1;
                    echo "<div id='handicap_tag_".$tag['id']."' class='handicap_tag' data-tag='$key' style='background-image: url(img/numeros_$tag_corr.svg)'>$tag_corr</div>";
                }
                ?>
            </div>
        </div>
        <div class="down-cross"><a href="immagine.php?id=<?=$carton?>">
        <img id="video" class="down-video open_video" src="img/videoicon.png">
        <img src="img/cross.png" class="down-cross-size" alt="cross"></a>
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
    var url = 'pinturas/<?=$img?>'

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

    //Definir el disseny dels tags
    var myIcon = L.icon({
        iconUrl: 'img/infopoint.png',
        iconSize:     [55, 55],
        iconAnchor:   [15, 15],
        popupAnchor:  [185, 00]
    });

    var markers = [];

    //Executem per ajax el doc get_image_tags.php que fa la consulta dels tags i ens retorna el resultat aquí
    $.ajax({
        url: 'php/get_image_tags.php',
        data: {
        carton_id: <?=$_GET['id']?>,
        },
        dataType: 'json',
        method: 'post',
        beforeSend: function(){
          console.log(<?=$_GET['id']?>)
        },
        success:function(resp){  
            resp.forEach( (tag,index) => {
              console.log(index);
                var marker = L.marker([tag.x, tag.y],{
                  icon: myIcon
                }).addTo(map);
                var popup = L.popup().setContent('<p class="add_red"><span class="close_tag" data-popup="'+index+'"></span>'+tag.desc+'</p>');
                markers[index] = marker.bindPopup(popup);
            });
        }
    });

    /***************/
    /* Minusvàlids */
    /***************/

    // Abrir handicap
    $(document).on('click','.handicap',function(){
        $('#add-div').toggleClass('hiding'); 
    });

    //Minusvàlids -> Obrim el tag corresponent al numero
    $('.handicap_tag').on('click',function(){
        var tag_corr = $(this).data('tag');
        markers[tag_corr].openPopup();
    });

    //Cerrar popup con cruz
    $(document).on('click','.close_tag',function(){
      var tag_corr = $(this).data('popup');
      markers[tag_corr].closePopup();
    });

    //Al principio esta activo el boton de Ok para que cierren instrucciones
    $('.instrucciones_boton').on('click',function(){
        $('.instrucciones_ok').removeClass('activo');
        $('.correspondencia_tags').addClass('activo');
    })

    $('.instrucciones_boton2').on('click',function(){
    $('.instrucciones_ok').removeClass('activo');
    $('.correspondencia_tags').addClass('activo');
})


});

</script>

</body>
</html>