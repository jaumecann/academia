$(document).ready(function(){

    var img1 = "<img class=\"arrowleft\" src=\"img/toleft.png\"></img>";   
    var img2 = "<img class=\"arrowbottom\" src=\"img/tobottom.png\"></img>";
    var img3 = "<img class=\"arroetop\" src=\"img/totop.png\"></img>";
    var img4 = "<img class=\"arrowright\" src=\"img/toright.png\"></img>";
        
    
    $("#chair").one("click", function(){
     $("#addonclick").append(img1, img2, img3, img4);
    });
    
    
    
    
    
    
    });