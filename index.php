<?php 
/*Requerim una sola vegada el head. Existeix també 'include_once'. La diferencia és que amb include si no es pot carregar l'arxiu la pagina segueix carregant-se,
    amb require en canvi es pararia tot i la pagina no carregaria.*/
    require_once('templates/head.php');
?>

<body>

<div id="wrapper">
    <div id="mainbox">
        <div class="lang" style="margin-bottom:10%;">
            <a href=# class="bold" style="margin-right:10px">IT</a> | <a href=# style="margin-left:10px">EN</a>
        </div>

        <div id="maintext">
            <h1>i cartoni<br>cinquecenteschi</h1><br>
            <p>una collezione di disegni<br>unica nel suo genere</p>
        </div>

        <!-- style=" width:auto; margin:auto;" --> 
        <div id="enter">
          <a href="home.php"><div class="button">ENTER</div></a> 
        </div>
      
        
        <div id="icon">
          <img src="" alt="mano-click">
        </div>
        
        <div id="logos">


         <div style="width:30%; ">
            <img src="img/logo1.png" class="responsive">
        </div>
        <div style="width:25%; ">
               <img src="img/logo2.png" class="responsive">
          </div>


    

          
            
            <img src="">
        </div>

    </div> <!-- end mainbox -->

</div> <!--end wrapper-->

</body>
</html>