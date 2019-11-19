

// js scroll
 /*   var gallery = document.getElementById("gallery");
    document.getElementsByClassName("rightarrow")[0].onclick= function () {
       gallery.scrollTo(300,0);
   }
*/


// js scroll continuat
/*
    document.getElementsByClassName("rightarrow")[0].onclick= move;
    
    function move () {
    var gallery = document.getElementById("gallery");
    var pos = gallery.scrollLeft;
    gallery.scrollTo(pos+50,0)
*/



// Scroll amb animació

/*
document.getElementsByClassName("rightarrow")[0].onclick= move;
    
function move () {
var gallery = document.getElementById("gallery");
var pos = gallery.scrollLeft;

    var anim = setInterval(toRight,5);

    function toRight (){
        if (gallery.scrollLeft == 100) {
            clearInterval(anim);
        } else {
            pos++
            gallery.scrollTo(pos,0);
        }
    }

   };

*/

$(document).ready(function(){


// transicions laterals

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


// icones amagades handicapped


});
  