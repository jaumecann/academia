$(document).ready(function(){
    
    /* Gestion abrir y cerrar instrucciones */
    $(document).on('click','.instrucciones_boton',function(){
        $('.instrucciones').removeClass('activo');
    });

    $(document).on('click','.instrucciones_boton2',function(){
        console.log("asdasd")
        $('.instrucciones').removeClass('activo');
    });

    /* Funcionamiento video grande */
    var video = document.getElementById('video');
    $('.open_video').on('click',function(){
        document.getElementById('video-div').style.display = "block";
        video.play();
    });
    $('#quit-video').on('click', function(){
        document.getElementById('video-div').style.display = "none";
        video.pause();
        video.currentTime = 0;  
    });
    

});