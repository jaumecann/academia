<?php require_once "templates/head.php"; ?>
<body>
<div class="background">
<?php require_once "templates/navbar.php"; ?>
    <div class="breadcrumbs">
        <p><a href="home.php">i cartoni cinquecenteschi</a> / </p>
    </div>
    <div class="bigcontainer">
        <div class="galeria_flecha leftarrow" ><img src="img/left_arrow.png" alt="go left"></div>
        <div id="gallery">
            <div class="handicap_cursor"></div>
            <div id="flexcont" class="cont_galeria">
                
                <?php 
                    $consulta_cuadros = 
                    "SELECT 
                        cartones.id,
                        cartones.title,
                        cartones.previewUrl,
                        author.name,
                        author.birthYear,
                        author.deathYear,
                        author.birthPlace,
                        author.deathPlace
                    FROM cartones
                    INNER JOIN 
                        author ON cartones.author_id = author.id
                        ORDER BY cartones.id";
                    
                    $exec_cuadros = $conn -> prepare($consulta_cuadros);
                    $exec_cuadros -> execute();
                    $resultado = $exec_cuadros->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($resultado as $key){
                        $fecha = '('.$key['birthPlace'].' '.$key['birthYear'].', '.$key['deathPlace'].' '.$key['deathYear'].')';
                ?>
                    <div class="frame">
                        <img src="pinturas/<?=$key['previewUrl']?>">
                        <a class="layer" href="cartone.php?id=<?=$key['id']; ?>">
                            <p class="layer-nombre"><?php echo $key['title']?></p>
                            <p class="layer-autor"><?=$key['name']?></p>
                            <p class="layer-fecha"><?=$fecha?></p>
                            <div class="frame_go" style="color: white">Vai</div>
                        </a>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="galeria_flecha rightarrow">
            <img src="img/right_arrow.png" alt="right arrow">
        </div>
    </div>
    <div class="footer">
        <div class="handicap open_handicap">
            <img id="chair" src="img/handic.png" alt="handicap">
        </div>
        <div id="add-div" class="hiding">
            <div class="handicap_shortcuts">
                <img onclick="mover_cursor('left')" class="handicap_moveLeft" src="img/toleft.png">   
                <img onclick="mover_cursor('down')" class="handicap_moveBottom" src="img/tobottom.png">  
                <img onclick="mover_cursor('up')" class="handicap_moveUp" src="img/totop.png">   
                <img onclick="mover_cursor('right')" class="handicap_moveRight" src="img/toright.png">   
            </div>
            <div class="button handicap_select" onclick="selecciona_frame()"><p>SELEZZIONA</p></div> 
            <div class="down-cross down-video">
                <img id="video" class="open_video" src="img/videoicon.png">
            </div>
        </div>
    </div>
</div>
</body>

<script>
$(document).ready(function(){


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

. El cursor traspasa las flechas al ir a izquierda o derecha y el collider devuelve Null

- Estaria bien un boton para ir directo al principio
- Falta en el diseño basico la flechita para ir

*/

//Pillamos los frames (esto devuelve un array con todos los .frame)
var frames = $('.frame');
//Al iniciar la app el frame activo es el primero
var frame_activo = frames[0];
//Guardamos el cursor handicap (el div que se irá moviendo por los frames para saber donde estamos)
var cursor = document.getElementsByClassName('handicap_cursor')[0];
//Preparamos las siguientes variables para tenerlas en global mas adelante
var cursor_x, cursor_y;
//Esto es porque en un momento determinado puede entrar en bucle buscando un frame que no existe, mas adelante se pone true si pasa esto y para el bucle
var try_scroll = false;

// Funcion para Muever el cursor
function mover_cursor(dir){
    /* Deshabilitamos el clic durante 500ms para que no puedan hacer clicklicliclic 57 veces seguidas
    sin dejar al scroll moverse y todo esto que tiene que hacer y liarla */
    $('.handicap_shortcuts').children('img').addClass('noclick');
    setTimeout(() => {
        $('.handicap_shortcuts').children('img').removeClass('noclick');
    }, 520);
    
    /* Recogemos la posicion actual del cursor */
    cursor_x = cursor.offsetLeft;
    cursor_y = cursor.offsetTop;
    console.log("Posicion inicial: "+cursor_x+","+cursor_y);
    /* Vemos el desplazamiento relativo del cursor */
    var next_sideMove = $(frame_activo).outerWidth()/2 + 20;
    var next_vertMove = $(frame_activo).outerHeight()/2 + 20;
    if(dir == 'left'){
        /* La posición final será el desplazamiento relativo + la posición actual del cursor */
        let posicion_final = cursor_x - next_sideMove;
        $(cursor).css({left:posicion_final});
    }
    if(dir == 'right'){
        let posicion_final = cursor_x + next_sideMove;
        $(cursor).css({left:posicion_final});
    }
    if(dir == 'up'){
        let posicion_final = cursor_y - next_vertMove;
        $(cursor).css({top:posicion_final});
    }
    if(dir == 'down'){
        let posicion_final = cursor_y + next_vertMove;
        $(cursor).css({top:posicion_final});
    }
    collide_cursorFrame()
}

// Reconoce el div que está debajo del cursor y lo marca
/* Aquí tambien se lucha duro para que en caso de no estar encima de un frame haga lo correspondiente en cada 
situación */
function collide_cursorFrame(){
    var cursor_position = cursor.getBoundingClientRect();
    var cursor_x_test = cursor_position['x'] + 2; //Esto es +2 porque sino el getBoundingClientRect devuelve el cursor, no lo que hay debajo
    var cursor_y_test = cursor_position['y'];
    
    /* Vemos con qué colide y actuamos en conseqüencia */
    frame_activo_test = document.elementFromPoint(cursor_x_test,cursor_y_test);

    console.log(frame_activo_test);
    /* Si es un frame, lo guardamos en frame_activo y aplicamos las clases que tocan, 
    luego centramos el cursor y el scroll a la nueva situación*/
    if(frame_activo_test.classList.contains('frame')){
        console.log("Es un frame, centramos");
        frame_activo = frame_activo_test;
        $('.frame').removeClass('handicap_selected');
        $(frame_activo).addClass('handicap_selected');
        try_scroll = false;

        centrar_cursor();
        centrar_scroll();
    }else if(frame_activo_test.classList.contains('cont_galeria')){
    /* Si colide con cont_galeria significa que está dentro de la zona de los frames pero no toca ningun frame,
    así que está en el puto medio de dos frames. Esto puede pasar en el movimiento vertical o en los limites */
    /* Solamente nos movemos 20px a un lado y volvemos a la accion */
        console.log("Esta en un punto medio");
        $(cursor).css('left','+=20');
        console.log("Cursor desplazado 20px a un lado");
        collide_cursorFrame();
    }else if(frame_activo_test.classList.contains('galeria_flecha') && try_scroll==false){
    /* Si colide con una flecha hay que hacer scroll UNA VEZ un poco y volverlo a intentar
    Si no se limita a uan vez, como hay un punto en el que no se puede hacer mas scroll, no para de colisionar 
    con la flecha y entra en bucle. Para eso esta la variable try_scroll. */
    // Si detecta la flecha, se mueve un poco, y aún así no encuentra frame, no va a entrar en este if otra vez por el try_scroll que sera true

        console.log("Esta en una flecha, intentar desplazar scroll una vez");
        try_scroll = true;
        if(frame_activo_test.classList.contains('rightarrow')){
            $("#gallery").animate({
                scrollLeft: $("#gallery").scrollLeft() + 200
            }, 500, function(){
                console.log("Tornem a trobar el punt");
                collide_cursorFrame();
            });

        }else if(frame_activo_test.classList.contains('leftarrow')){
            $("#gallery").animate({
                scrollLeft: $("#gallery").scrollLeft() - 200
            }, 500, function(){
                console.log("Tornem a trobar el punt");
                collide_cursorFrame();
            });
        }
    }else{
    /* Si no es un frame ni esta en la zona intermedia ni es una flecha ni habiendo movido el scroll ha encontrado nada,
    se queda como está. Significa que esta en un limite y no puede tirar mas. No insista señor.
    centramos el scroll al frame_activo por si se movió al intentar hacer scroll para pillar algun frame*/
        console.log("No esta en un frame");
        $(cursor).css({left:cursor_x});
        $(cursor).css({top:cursor_y});
        centrar_scroll();
    }
}

/* Centrar el scroll al frame activo */
function centrar_scroll(){
    /* Si el frame activo no se ve entero, hace scroll para centrarlo */
    // Vemos el tamaño x del contenedor galeria
    var w_galeria = $('#gallery').width();
    console.log("Width galeria: "+w_galeria);

    // Vemos la posicion x, la posicion del scroll y el width del frame
    var pos_scroll = $('#gallery').scrollLeft();
    var w_frame = $(frame_activo).width();
    var pos_frame = frame_activo.offsetLeft;
    console.log("Width: "+w_frame+", pos: "+pos_frame);
    console.log("Scroll pos: "+pos_scroll);

    // Con esto vemos si el frame se sale de la galeria por la derecha
    if(w_frame + pos_frame > w_galeria + pos_scroll){
        var dif = (w_frame+pos_frame)-(w_galeria+pos_scroll);
        console.log("El frame se sale por la derecha "+dif+"px");
        $("#gallery").animate({
            // Y lo desplazamos hasta que se vea todo
            // Osea los pixeles que se sale + unos pocos mas para que no se quede justo al limite del contenedor
            scrollLeft: $("#gallery").scrollLeft() + (dif + 30) 
        }, 500);
    }else{
        console.log("El frame esta dentro por la derecha");
    }

    // Y con esto si se sale por la izquierda
    if(pos_frame < pos_scroll){
        var dif = pos_scroll-pos_frame;
        console.log("El frame se sale por la izquierda "+dif+"px");
        $("#gallery").animate({
            scrollLeft: $("#gallery").scrollLeft() - (dif + 30)
        }, 500);
    }else{
        console.log("El frame esta dentro por la izquierda");
    }
}

/* Pone el cursor en el centro del frame activo */
function centrar_cursor(){
    var width_frame = $(frame_activo).outerWidth();
    var height_frame = $(frame_activo).outerHeight();
    
    var final_posX = frame_activo.offsetLeft + width_frame /2;
    var final_posY = frame_activo.offsetTop + height_frame /2;

    $(cursor).css({top:final_posY,left:final_posX});
    
}

// Simula click al frame activo
function selecciona_frame(){
    url = frame_activo.children[1].getAttribute('href');
    console.log('Seleccionar frame '+url);
    location.href = url;
}

// Al inicio, cuando se han carga todas las iamgenes, centra el cursor a la primera
window.addEventListener('load',function(){
    centrar_cursor();
});

</script>

</html>