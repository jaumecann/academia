<?php
    require_once "conexion.php";
    $imagen = $_POST['image_id'];
    $get_tags = $conn->prepare("SELECT * FROM detail WHERE painting_id = :painting_id");
    $get_tags->bindParam(':painting_id', $imagen);
    $get_tags->execute();
    $resultado = $get_tags->fetchAll(PDO::FETCH_ASSOC);
    

    $tags = [];
    foreach($resultado as $tag){
        array_push($tags,$tag['paintingX'],$tag['paintingY'],$tag['descriptionIta']);
    }
    echo json_encode($tags);
?>