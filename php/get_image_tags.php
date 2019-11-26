<?php
    require_once "conexion.php";
    $carton = $_POST['carton_id'];
    $get_tags = $conn->prepare("SELECT * FROM detail WHERE painting_id = :carton_id");
    $get_tags->bindParam(':carton_id', $carton);
    $get_tags->execute();
    $resultado = $get_tags->fetchAll(PDO::FETCH_ASSOC);
    

    $tags = [];
    foreach($resultado as $tag){
        $tag_info = [
            'x'=>$tag['paintingX'],
            'y'=>$tag['paintingY'],
            'title'=>$tag['title'],
            'desc'=>$tag['descriptionIta']
        ];
        array_push($tags,$tag_info);
    }
    echo json_encode($tags);
?>