$(document).ready(function(){

    $("#chair").click(function(){
        $("#add-div").toggleClass("hiding");
        });        



});


// ZOOM IMATGE

function zoomin() {
    var myImg = document.getElementById("imgid");
    var currWidth = myImg.clientWidth;
    if (currWidth >= 2000){
    return false;
    } 
    else {
      myImg.style.width = (currWidth + 50) + "px";
    }
  };
  
  function zoomout() {
    var myImg = document.getElementById("imgid");
    var currWidth = myImg.clientWidth;
    if (currWidth <= 300) {
   return false;
    } else {
      myImg.style.width = (currWidth - 50) + "px";
    }
  };

  document.getElementById("lessbox").onclick=zoomout;
  document.getElementById("morebox").onclick=zoomin;

