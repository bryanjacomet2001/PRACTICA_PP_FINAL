<?php
    require_once '../model/certificadoDAO.php';

    /*SI EN EL COMBO BOX SE SELECCIONA LA OPCION DE TITULO, ENVIA LOS DATOS AL METODO GETALL DEL 
    CERTIFICADO.JS Y LLENA LA TABLA */

    if($_POST["filtro"] === "titulo"){
        $data = trim($_POST["campo"]);
        $certificado = new certificadoDAO();
        $resData = $certificado->getDataFilterTitle($data);
        echo json_encode($resData);
    }

    /*SI EN EL COMBO BOX SE SELECCIONA LA OPCION DE NOMBRE DE USUARIO, ENVIA LOS DATOS AL METODO GETALL DEL 
    CERTIFICADO.JS Y LLENA LA TABLA */

    if($_POST["filtro"] === "username"){
        $data = trim($_POST["campo"]);
        $certificado = new certificadoDAO();
        $resData = $certificado->getDataFilterUserName($data);
        echo json_encode($resData);
    }
?>