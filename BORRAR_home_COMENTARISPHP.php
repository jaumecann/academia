<?php 
    require_once "templates/head.php";
?>

<body>

<div class="background">

<?php 
    require_once "templates/navbar.php";
?>


    <div class="breadcrumbs">
        <p><span>i cartoni cinquecenteschi</span> / collezione</p>
    </div>

 <div id="bigcontainer">

    <div class="leftarrow" ><img src="img/left_arrow.png" alt="go left"></div>
    
    <div id="gallery">
        <div id="flexcont">
            <?php 
                /*Guardamos la consulta en una variable PHP para usarla mas adelante. 
                Esta consulta contiene un join porque queremos info del autor relacionado con el cuadro*/
                $consulta_cuadros = 
                "SELECT 
                    painting.id,
                    painting.title,
                    painting.panoUrl,
                    painting.imageUrl,
                    author.name,
                    author.birthYear,
                    author.deathYear,
                    author.birthPlace,
                    author.deathPlace 
                FROM painting
                INNER JOIN 
                    author ON painting.author_id = author.id";
                
                /*Lo siguiente es PDO, se puede hacer lo mismo con myslqi, son solo distintas formas de trabajar:
                https://www.seas.es/blog/informatica/pdo-o-mysqli-para-app-implementada-en-php/ */

                //Preparamos la consulta que hemos guardado antes a la $conn (que es la conexion creada a la bbdd en conexion.php)
                //Y guardamos esta 'preparacion', que no sé exactamente en qué consiste, en una variable php
                $exec_cuadros = $conn -> prepare($consulta_cuadros);
                //Ejecutamos la consulta que hemos guardado en $exec_cuadros
                $exec_cuadros -> execute();
                //Ahora a $exec_cuadros le podemos pedir distintas cosas referentes a la consulta. En este caso le pedimos
                //fetchAll, que nos da un array con toda la info, y la guardamos a $resultado.
                //Tembien se le puede pedir fetch, que devuelve la primera diria, y mas cosas que no controlo... pero google si: http://www.nusphere.com/kb/phpmanual/ref.pdo.htm (busca el apartado PDOStatement)
                $resultado = $exec_cuadros->fetchAll(PDO::FETCH_ASSOC);
                //Ahora ya tenemos en $resultado el array y lo tratamos casi como lo hariamos con un array de javascript
                foreach($resultado as $key){
                    $fecha = '('.$key['birthPlace'].' '.$key['birthYear'].', '.$key['deathPlace'].' '.$key['deathYear'].')';
            ?>
                <div class="frame">
                    <img src="pinturas/<?=$key['panoUrl'].'/'.$key['imageUrl']?>">
                    <a href="immagine.php?id=<?php echo $key['id']; ?>">
                        <div class="layer">
                            <p class="layer-nombre"><?php echo $key['title']?></p>
                            <p class="layer-autor"><?=$key['name']?></p>
                            <p class="layer-fecha"><?=$fecha?></p>
                        </div>
                    </a>
                </div>
            <?php
                }
            ?>
            
            <!-- 3 - Els textos, si fem servir spans i hem de posar diferents estils a cada un, hem de fer servir selectors
                    que acabaran siguent algo com 'Al primer span: tal, al segon: qual, al tercer... Al final el css acaba
                    siguent un lio (ref-3)
                    No passa res per posar classes a tot arreu, mentre el nom defineixi clarament on esta. 
                    També es pot fer una especia de 'bootstrap personalitzat' amb coses que veus que es fan servir molt -->
            <div class="frame"> 
                <img src="img/pieta.png"> 
                <a href="#"> 
                    <div class="layer">
                        <!-- Aquí hacemos lo de siempre de linkar algo por href a otra pagina, peeero
                        con una diferencia: Pasamos información por GET. Pasar datos por GET (y por POST) és basicoesencialimportante en PHP.  
                        Esencialmente GET y POST se usan para pasar informacion a través de paginas.
                        GET pone la información en la misma URL, es inseguro pero mandar informacion confidencial como users o passwords
                        POST la envia codificada.
                        En este caso la pasamos por get porque da igual la seguridad, para pasarlo lo metemos tal qual en la url
                        ponemos un ? seguido de el nombre que nos apetezca darle, = a variable que vamos a pasar.
                        Los posts se usan sobretodo en los formularios por ejemplo de registro de usuarios y tal.
                        https://diego.com.es/get-y-post-en-php-->
                        <a href="immagine.php?id=<?=$fila['id']?>" class="layer-nombre">Pietà per Vittoria Colonna</a>
                        <p class="layer-autor">Michelangelo Buonarroti</p>
                        <p class="layer-fecha">(Valduggia 1475ca, Milano 1546)</p>
                    </div>
                </a>
            </div>

        </div>
        
    </div>
    

    <!-- En general no se aconseja hacer styles dentro del html
    - por mantener un orden y saber que lo que busques lo encontrarás en la hoja de estilos
    - porque un estilo puesto directamente aquí tiene prioridad sobre todo lo demás que se le aplique 
    desde otro lado, y al final acabará jodiendote por un lado u otro.
    Ademas tiene clases compartidas con la otra flecha, se puede meter todo en una clase .arrows_galeria y luego en
    .rightarrow meter solamente el flex-end. 
    -->
    <div class="rightarrow">
        <img src="img/right_arrow.png" alt="right arrow">
    </div>


</div> <!-- end of big container-->

    <div class="footer">
        <div><img id="chair" src="img/handic.png" alt="handicap"></div>

        <div id="add-div" class="hiding">
            <img src="img/toleft.png">   
            <img src="img/tobottom.png">  
            <img src="img/totop.png">   
            <img src="img/toright.png">    
            </div>
    </div>

</div>


</body>


<script src="scripts/galeria.js"></script>
<script src="scripts/home.js"></script>

<!--


    -->
</html>