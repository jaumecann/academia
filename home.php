<?php require_once "templates/head.php"; ?>
<body>
<div class="background">
<?php require_once "templates/navbar.php"; ?>
    <div class="breadcrumbs">
        <p><span>i cartoni cinquecenteschi</span> / collezione</p>
    </div>
    <div id="bigcontainer">
        <div class="leftarrow" ><img src="img/left_arrow.png" alt="go left"></div>
        <div id="gallery">
            <div class="handicap_cursor"></div>
            <div id="flexcont">
                
                <?php 
                    $consulta_cuadros = 
                    "SELECT 
                        painting.id,
                        painting.title,
                        painting.panoUrl,
                        painting.imageUrl,
                        author.name,
                        author.birthYear,
                        author.deathYear,
                        author.birthPlace,
                        author.deathPlace 
                    FROM painting
                    INNER JOIN 
                        author ON painting.author_id = author.id";
                    
                    $exec_cuadros = $conn -> prepare($consulta_cuadros);
                    $exec_cuadros -> execute();
                    $resultado = $exec_cuadros->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($resultado as $key){
                        $fecha = '('.$key['birthPlace'].' '.$key['birthYear'].', '.$key['deathPlace'].' '.$key['deathYear'].')';
                ?>
                    <a class="frame" href="immagine.php?id=<?php echo $key['id']; ?>">
                        <img src="pinturas/<?=$key['imageUrl']?>">
                        <div class="layer" href="immagine.php?id=<?php echo $key['id']; ?>">
                            <p class="layer-nombre"><?php echo $key['title']?></p>
                            <p class="layer-autor"><?=$key['name']?></p>
                            <p class="layer-fecha"><?=$fecha?></p>
                        </div>
                    </a>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="rightarrow">
            <img src="img/right_arrow.png" alt="right arrow">
        </div>
    </div>
    <div class="footer">
        <div class="handicap">
            <img id="chair" src="img/handic.png" alt="handicap">
        </div>
        <div id="add-div" class="hiding">
            <img onclick="mover_cursor('left')" class="handicap_moveLeft" src="img/toleft.png">   
            <img onclick="mover_cursor('down')" class="handicap_moveBottom" src="img/tobottom.png">  
            <img onclick="mover_cursor('up')" class="handicap_moveUp" src="img/totop.png">   
            <img onclick="mover_cursor('right')" class="handicap_moveRight" src="img/toright.png">    
        </div>
    </div>
</div>
</body>

<script>
$(document).ready(function(){


    // Abrir el menú de minusválidos
    $('.handicap').click(function(){
        $('#add-div').toggleClass('hiding');
        $('.handicap_cursor').toggleClass('activo');
        $('.frame').toggleClass('handicap_active');
        collide_cursorFrame()
    });

    // Transicions laterals
    $(".rightarrow").click(function(){
        $("#gallery").animate({
            scrollLeft: $("#gallery").scrollLeft() + 200
        }, 500);
    });
    $(".leftarrow").click(function(){
        $("#gallery").animate({
            scrollLeft: $("#gallery").scrollLeft() - 200
        }, 500);
    });

});


/* FUNCIONAMIENTO CURSOR MINUSVÁLIDOS*/


/* Falta solucionar: 
- Cuando el cursor se quiere salir de los frames, es decir tirar arriba quando no hay mas,
se debe bloquear / o salir por el otro lado
- Hay casos raros en los que puede que el cursor se quede entre las fotos, en la parte negra,
allí se pondría en el medio del div contenedor, porque se centra a lo que toca. Es evidentemente
un error.
- Boton de pulsar
- Falta en el diseño basico la flechita para ir
- Falta en el menu de minusvalidos el boton de seleccionar
*/


// Pone el cursor de minusválidos al centro de la primera foto
var frames = $('.frame');
var cursor = document.getElementsByClassName('handicap_cursor')[0];
var frame_activo = frames[0];

// Mueve el cursor
function mover_cursor(dir){
    var next_sideMove = $(frame_activo).outerWidth()/2 + 20;
    var next_vertMove = $(frame_activo).outerHeight()/2 + 20;
    if(dir == 'left'){
        let posicion_final = cursor.offsetLeft - next_sideMove;
        $(cursor).css({left:posicion_final});
    }
    if(dir == 'right'){
        let posicion_final = cursor.offsetLeft + next_sideMove;
        $(cursor).css({left:posicion_final});
    }
    if(dir == 'up'){
        let posicion_final = cursor.offsetTop - next_vertMove;
        $(cursor).css({top:posicion_final});
    }
    if(dir == 'down'){
        let posicion_final = cursor.offsetTop + next_vertMove;
        $(cursor).css({top:posicion_final});
    }
    collide_cursorFrame();
}

// Reconoce el div que está debajo del cursor y lo marca
function collide_cursorFrame(){
    //Ver la posicion x,y del cursor
    var cursor_position = cursor.getBoundingClientRect();
    //Ver qué frame hay en la posición del cursor
    //(Sumamos 2px porque sino saldria que en la posicion del cursor hay el cursor mismo)
    var cursor_x = cursor_position['x'] + 2;
    var cursor_y = cursor_position['y'];
    /*elementFromPoint devuelve el ultimo elemento que hay en esta posicion del dom, 
    es decir el que no tiene hijos, entonces me devolvía la imagen y no el frame. 
    Peero elementFromPoint ignora los elementos sin pointer-events, así que se lo puse a 
    none en CSS para que pille el frame y no la img*/
    frame_activo = document.elementFromPoint(cursor_x,cursor_y);
    $('.frame').removeClass('handicap_selected');
    $(frame_activo).addClass('handicap_selected');

    centrar_cursor();
}

// Pone el cursor en el centro de un frame determinado
function centrar_cursor(){
    var width_frame = $(frame_activo).outerWidth();
    var height_frame = $(frame_activo).outerHeight();
    
    var final_posX = frame_activo.offsetLeft + width_frame /2;
    var final_posY = frame_activo.offsetTop + height_frame /2;

    $(cursor).css({top:final_posY,left:final_posX});
}


window.addEventListener('load',function(){
    centrar_cursor();
});

</script>


<!--<script src="scripts/galeria.js"></script>
<script src="scripts/home.js"></script>-->
</html>