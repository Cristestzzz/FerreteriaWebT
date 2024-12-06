<?php
require "../funciones/conexionbd.php";

if($_POST['tipoAccion'] === "añadir"){
    $nombre = $_POST['nombre_producto'];
    $precio = $_POST['precio_producto'];
    $stock = $_POST['stock_producto']; // Capturamos el stock

    if(!isset($_POST['categoria_producto'])){ /**Devolvera error si no se eligio ninguna categoria */
        $respuesta = array(
            "respuesta" => "error"
        );
        die(json_encode($respuesta));
    }

    $categoria = $_POST['categoria_producto'];

    try {
        if($_FILES["imagen_producto"]["error"] === 4){//error 4 : no se subio ningun archivo (imagen producto)

            $stmt = $conn->prepare("INSERT INTO productos (nombre_producto, precio_producto, stock, categoria_id) VALUES(?,?,?,?)"); 
            $stmt->bind_param("sdii", $nombre, $precio, $stock, $categoria); // Añadido stock

        }else{

            $directorio = "../../../img/productos/";
            if(!is_dir($directorio)){
                mkdir($directorio, 0755,true);//Crea una carpeta
            }
    
            if(move_uploaded_file($_FILES["imagen_producto"]["tmp_name"], $directorio.$_FILES["imagen_producto"]["name"])){
                $imagen_url = $_FILES["imagen_producto"]["name"];
            }
            else{
                $respuesta = array(
                    "respuesta" => error_get_last()
                );
            }
            $stmt = $conn->prepare("INSERT INTO productos (nombre_producto, precio_producto, url_img, stock, categoria_id) VALUES(?,?,?,?,?)"); 
            $stmt->bind_param("sdssi", $nombre, $precio, $imagen_url, $stock, $categoria); // Añadido stock
        }
        
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $respuesta = array(
                "respuesta" => "exito",
                "accion" => "crear"
            );
        }
        else{
            $respuesta = array(
                "respuesta" => "error"
            );
        }
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $respuesta = array(
            "respuesta" => $e->getMessage()
        );
    }
    echo json_encode($respuesta);
}
    
else if($_POST['tipoAccion'] === "editar"){

    $nombre = $_POST['nombre_producto'];
    $precio = $_POST['precio_producto'];
    $stock = $_POST['stock_producto']; // Capturamos el stock
    $categoria = $_POST['categoria_producto'];
    $id_registro = $_POST['id_registro'];

    try {

        if($_FILES["imagen_producto"]["error"] === 4){//error 4 : no se subio ningun archivo

            // Sin imagen (imagen no cambia)
            $stmt = $conn->prepare("UPDATE productos SET nombre_producto= ?, precio_producto=?, stock=?, categoria_id=?, editado=NOW() WHERE id_producto=?");
            $stmt->bind_param("sdiii", $nombre, $precio, $stock, $categoria, $id_registro); // Añadido stock

        }else{
            $directorio = "../../../img/productos/";
            if(!is_dir($directorio)){
                mkdir($directorio, 0755,true);//Crea una carpeta
            }

            if(move_uploaded_file($_FILES["imagen_producto"]["tmp_name"], $directorio.$_FILES["imagen_producto"]["name"])){
                $imagen_url = $_FILES["imagen_producto"]["name"];
            }
            else{
                $respuesta = array(
                    "respuesta" => error_get_last()
                );
            }

            // Con imagen (imagen cambia)
            $stmt = $conn->prepare("UPDATE productos SET nombre_producto= ?, precio_producto=?, url_img=?, stock=?, categoria_id=?, editado=NOW() WHERE id_producto=?");
            $stmt->bind_param("sdssii", $nombre, $precio, $imagen_url, $stock, $categoria, $id_registro); // Añadido stock
        }
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $respuesta = array(
                "respuesta" => "exito",
                "accion" => "editar"
            );
        }
        else{
            $respuesta = array(
                "respuesta" => "error"
            );
        }
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $respuesta = array(
 "respuesta" => $e->getMessage()
        );
    }
    echo json_encode($respuesta);
}

else if($_POST['tipoAccion'] === "borrar"){
    $id_registro = $_POST['id_registro'];
    try {
        $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto=?");
        $stmt->bind_param("i", $id_registro);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $respuesta = array(
                "respuesta" => "exito"
            );
        }
        else{
            $respuesta = array(
                "respuesta" => "error"
            );
        }
        
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $respuesta = array(
            "respuesta" => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}
?>