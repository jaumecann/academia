
/*
document.getElementById('bright').addEventListener('input', function () {
    document.body.style.opacity = this.value;
});
*/


$(document).ready(function(){



//  BRIGHTNESS

var toclick = "img/brighticon.png";
var clicked = "img/bright2.png";
var percent = "<p>100%</p>";
var range = "<div class=\"slidecontainer\"><input type=\"range\" id=\"bright\" min=\"0\" max=\"100\" class=\"slider\" value=\"100\"></div>";
var minbr = "<img src=\"img/minbr.png\" alt=\"down\" id=\"brless\">";
var maxbr = "<img src=\"img/maxbr.png\" alt=\"up\" id=\"brmore\">";
var minlupa = "<img src=\"img/less.png\" alt=\"down\" id=\"less\">";
var maxlupa = "<img src=\"img/more.png\" alt=\"down\" id=\"more\">";

$("#brightness").on('click',function(){
   if ($(this).attr('src')== toclick){
        $(this).attr('src', clicked)
        $("#progressarea p").replaceWith(range);
        $("#less").replaceWith(minbr);
        $("#more").replaceWith(maxbr);
        
document.getElementById("bright").addEventListener("input", function () {
    document.getElementsByClassName("imgcont")[0].style.opacity = this.value / 100;
})

    } else {
        $(this).attr('src', toclick);
        $("#progressarea input").replaceWith(percent);
        $("#brless").replaceWith(minlupa)
        $("#brmore").replaceWith(maxlupa)
        
    };

  
})

// ZOOM IMATGE

function zoomin() {
    var myImg = document.getElementById("imgid");
    var currWidth = myImg.clientWidth;
    if (currWidth == 2000){
    return false;
    } 
    else {
      myImg.style.width = (currWidth + 50) + "px";
    }
  };
  
  function zoomout() {
    var myImg = document.getElementById("imgid");
    var currWidth = myImg.clientWidth;
    if (currWidth == 500) {
   return false;
    } else {
      myImg.style.width = (currWidth - 50) + "px";
    }
  };

  document.getElementById("less").onclick=zoomout;
  document.getElementById("more").onclick=zoomin;





});//end jquery



// Pure JS image zoom A PEN BY Alex Galushka
// https://stackoverflow.com/questions/47635341/zooming-in-out-an-image-by-clicking-zoom-buttons-javascript