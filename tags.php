<?php 
  require_once "templates/head.php";
  $imagen = $_GET['id'];

  $exec_imagen = $conn->prepare("SELECT * FROM cartones WHERE id = :imagen");
  $exec_imagen->bindParam(':imagen',$imagen);
  $exec_imagen->execute();
  $resultado = $exec_imagen -> fetch(PDO::FETCH_ASSOC);
  $title = $resultado['title'];
  $img = $resultado['imageUrl'];

  $get_tags = $conn->prepare("SELECT * FROM detail WHERE painting_id = :painting_id");
  $get_tags->bindParam(':painting_id', $imagen);
  $get_tags->execute();
  $resultado_tags = $get_tags->fetchAll(PDO::FETCH_ASSOC);
?>

<body>


<div class="background">

  <?php require_once "templates/navbar.php"; ?>

  <div class="breadcrumbs">
    <p><a href="immagine.php?id=<?=$imagen?>"><?=$title?></a> / <span class="bread2">esplora i dettagli</span>
    <a class="close_breadcrumbs" href="immagine.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
  </div>

  <section class="contents">
    
  
    <div class="instrucciones activo">
      <div class="instrucciones_content">
        <div class="instrucciones_icon">
          <img src="img/infoicon.png">
        </div>
        <div class="instrucciones_texto">
            <h3>esplora i dettagli</h3>
            <p>clicca sulla "i" per scoprire i dettagli del cartone</p>
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
                <div class="instrucciones_boton">OK</div>
            </div>
            <div class="correspondencia_tags">
                <?php
                foreach($resultado_tags as $key=>$tag){
                    $tag_corr = $key + 1;
                    echo "<div id='handicap_tag_".$tag['id']."' class='handicap_tag' data-tag='$key'>$tag_corr</div>";
                }
                ?>
            </div>
        </div>
        <div class="down-cross size-cross"><a href="immagine.php?id=<?=$imagen?>"><img src="img/cross.png" alt="cross"></a>
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
        iconSize:     [35, 35],
        iconAnchor:   [15, 15],
        popupAnchor:  [60, 55]
    });

    var markers = [];

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

    //Al principio esta activo el boton de Ok para que cierren instrucciones
    $('.instrucciones_boton').on('click',function(){
        $('.instrucciones_ok').removeClass('activo');
        $('.correspondencia_tags').addClass('activo');
    })

});

</script>

</body>
</html>