$(document).ready(function(){
    
    /* Gestion abrir y cerrar instrucciones */
    $(document).on('click','.instrucciones_boton',function(){
        $('.instrucciones').removeClass('activo');
    });

    $(document).on('click','.instrucciones_boton2',function(){
        console.log("asdasd")
        $('.instrucciones').removeClass('activo');
    });

    $('.open_video').on('click',function(){
        showVideo();
    });

    $('#quit-video').on('click', function(){
        hideVideo();
    });
    
});

var video = document.getElementById('video');

//Cuando termina el video se tiene que cerrar automaticamente
video.addEventListener('ended',hideVideo,false);

function showVideo(){
    ajaxLuz(0); //Apaga la luz al entrar al video
    document.getElementById('video-div').style.display = "block";
    video.play();
}

function hideVideo(){
    document.getElementById('video-div').style.display = "none";
    video.pause();
    video.currentTime = 0;
    ajaxLuz(1); //Enciende la luz al salir del video
}

/* Post comportamiento luz */
function ajaxLuz(toState){
    console.log(toState);
    $.post('ajax/funcionamientoLuz.php?switchLights='+toState)
}