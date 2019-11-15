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
        <a href="home.php"><img src="img/back.png" alt="go back">
    </div></a>

    <section id="cartone">
        <div class="imgdiv"><img src="pinturas/pieta.png"></div>
        <div class="bigtxtdiv">
            <h3>Pietà per Vittoria Colonna </h3>
            <p class="bold">Michelangelo Buonarroti</p>
            <p>(Valduggia 1475ca, Milano 1546)</p>
            <p>Carboncino, matita nera e gessetto su carta.</p>
        </div>
        <div class="txtdiv">
            <p>I tratta di una preziosa raccolta di cinquantanove cartoni preparatori, che si
                riferiscono quasi tutti a importanti dipinti di Gaudenzio Ferrari e della sua
                scuola. Datati in un arco di tempo che va dal 1515 al 1610, i cartoni rivelano
                un’unica provenienza geografico-artistica, quella delle botteghe attive a
                Vercelli nel corso del XVI secolo. La fioca luce che illumina la sala, necessaria
                per una corretta conservazione delle opere su carta.</p>
        </div>
        <div class="btndiv">
            <a href="immagine.php"><div id="esplora">
                <a href="#"><div class="button espl-btn">ESPLORA L'IMMAGINE</div></a> 
              </div>
            </a>  
        </div>
    </section>



    <?php 
    require_once "templates/footer.php";
?>



</body>
</html>