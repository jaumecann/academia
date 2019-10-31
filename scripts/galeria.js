$(document).ready(function(){

    $(".rightarrow").click(function(){
        $("#gallery").scrollLeft(300);
    });

    $(".leftarrow").click(function(){
        $("#gallery").scrollLeft(-300);
    });
  
  });