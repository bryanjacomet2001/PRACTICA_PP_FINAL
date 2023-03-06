<?php

// OBTENGO EL SUBMISSION ID DEL ARTICULO
if($_GET) $_id= $_GET["idSub"];

// LLAMO LA LIBRERIA DONPDF Y LA CLASE QUE TIENE LOS PROCEDIMIENTOS ALMACENADOS
require_once "../libs/dompdf/autoload.inc.php";
require_once '../model/certificadoDAO.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

try {
  // INSTANCIO UNA CLASE PARA USAR LOS METODOS QUE SE CONECTAN CON LA BD
  $certificado = new certificadoDAO();

  //COMIENZO A OBTENER EN MEMORIA EL HTML Y LOS DATOS QUE SE ENVIARAN
  ob_start();
  /*OBTENGO LOS DATOS DEL ARTÍCULO */
  $res_title = $certificado->getTitle($_id);
  $res_date = $certificado->getDatePublication($_id);

  $res_id = $certificado->getIdAuthors($_id);
  $array_data_tmp = array();
  $res_vol_num = $certificado->getVol_num($_id);

  foreach ($res_id as $i){
    $res_data_author = $certificado->getDataAuthors($i["AUTHOR_ID"]);
    array_push($array_data_tmp, $res_data_author);
  }

  /*ENVIO LOS DATOS AL ARCHIVO HTML/PHP QUE SE VA A RENDERIZAR */
  include "../Handler/certificado.tpl.php";
  /* GUARDO EL ARCHIVO HTML/PHP CON TODOS LOS DATOS ORDENADOS Y ESTILOS */
  $html = ob_get_clean();

  /* COMIENZO A CREAR EL PDF */
  $dompdf = new Dompdf(["isRemoteEnabled" => true]); 
  $dompdf->load_html($html); 
  $dompdf->render(); 
  $dompdf->add_info("Title", "Certificado"); 
  $dompdf->stream("Certificado.pdf", ["Attachment" => 0]); 

} catch (\Throwable $th) {
    echo "Ocurrio un error".$th;
}

?>
