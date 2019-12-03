<?php require_once('templates/head.php') ?>

<body>

<div id="video-div"> 
    <div id="quit-video">
        <img src="img/cross.png" alt="cross">
    </div> 
    <div id="flex-div">
        <video id="video" width="100%" height="auto">
            <source src="img/videoplayback.mp4" type="video/mp4">
        </video>
    </div>
</div> 

<div class="vistamedia_content">
    <div class="mediaFoto open_video">
        <div class="centerBlock">
            <img alt="Play video" src="img/videoicon.png" width="100">
        </div>
    </div>
    <div class="barraInf">
        <div class="luz" id="changeLight" class="bombilla"></div>
        <a class="lupa" href="home.php"></a>
    </div>
</div>

</body>

<script src="scripts/principal.js"></script>

<script>
$(document).ready(function(){
    //Cuando se carga la pagina pilla el GET de la URL para saber qué hacer con las luces
    let params = new URLSearchParams(location.search);
    var toState = params.get('toLight');

    ajaxLuz(toState);

    //Boton de encender y apagar la luz
    $('#changeLight').click(function(){
        toState = (toState == 0 ? 1 : 0);
        ajaxLuz(toState);
    })
});
</script>

<style>
.mediaFoto{
    width: 100%;
    height: 1300px;
    background-image: url("img/background.png");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: top;
    position: relative;
}
.vistamedia_content{
    display:flex;
    justify-content: center;
    height:100%;
    background-color: black;
}
.centerBlock{
    position: absolute;
    width: 150px; height: 150px;
    background-color: black;
    left: 50%; bottom: 0;
    transform: translate(-50%,50%);
    border-radius: 100%;
    display: flex;
    align-items: center; 
    justify-content: center;
}
.barraInf{
    width: 100%; height: 100px;
    display: flex;
    position: fixed;
    bottom: 100px;
    justify-content: space-between;
    padding: 0 180px;
    box-sizing: border-box;
}
.barraInf a,.barraInf div{
    width: 100px;
    height: 100px;
}
.barraInf .luz{
    background: url('img/lightbulb.svg') no-repeat center/contain;
}
.barraInf .lupa{
    background: url('img/loupe.svg') no-repeat bottom/85px;
}
</style>
</html>