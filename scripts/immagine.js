

/*
document.getElementById('bright').addEventListener('input', function () {
	document.body.style.opacity = this.value;
});
*/


$(document).ready(function(){

 $("#brightness").click(function(){
    $("#brightness").attr('src',"img/bright2.png");
    $(".percent p").replaceWith("<input type=\"range\" id=\"bright\" min=\"0\" max=\"100\" value=\"\">");


  
});//end jquery

// mirar jQuery Toggle Click Function A PEN BY html5andblog