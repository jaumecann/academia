
/*
document.getElementById('bright').addEventListener('input', function () {
    document.body.style.opacity = this.value;
});
*/


$(document).ready(function(){

    /*
 $("#brightness").click(function(){
    $("#brightness").attr('src',"img/bright2.png");
    $(".percent p").replaceWith("<input type=\"range\" id=\"bright\" min=\"0\" max=\"100\" value=\"\">");
*/

var toclick = "img/brighticon.png";
var clicked = "img/bright2.png";
var percent = "<p>100%</p>"
var range = "<input type=\"range\" id=\"bright\" min=\"0\" max=\"100\" value=\"100\">"

$("#brightness").on('click',function(){
   if ($(this).attr('src')== toclick){
        $(this).attr('src', clicked)
        $("#progressarea p").replaceWith(range);
        
document.getElementById("bright").addEventListener("input", function () {
    document.getElementById("imgcont").style.opacity = this.value / 100;
})

    } else {
        $(this).attr('src', toclick);
        $("#progressarea input").replaceWith(percent);
    };

  
})




});//end jquery


// mirar jQuery Toggle Click Function A PEN BY html5andblog
// Pure JS image zoom A PEN BY Alex Galushka
// https://stackoverflow.com/questions/47635341/zooming-in-out-an-image-by-clicking-zoom-buttons-javascript