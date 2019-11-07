$(document).ready(function(){

var img1 = "<img class=\"newbtn\" src=\"img/infopoint.png\"></img>"   
var img2 = "<img class=\"newbtn\" src=\"img/infopoint.png\"></img>"    

$("#chair").one("click", function(){
 $("#addonclick").append(img1, img2);
});






});