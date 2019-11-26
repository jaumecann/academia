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
    $('.open_video').on('click',function(){
        document.getElementById('video-div').style.display = "block";
        document.getElementById('video').play();
    });
    $('#quit-video').on('click', function(){
        document.getElementById('video-div').style.display = "none";
        var video = document.getElementById('video');
        video.pause();
        video.currentTime = 0;  
    });
    

});