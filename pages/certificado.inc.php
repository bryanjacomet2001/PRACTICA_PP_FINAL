<?php

// OBTENGO EL SUBMISSION ID DEL ARTICULO y EL JOURNAL_ID
if($_GET){
  $id = $_GET["idSub"];
  $journal = $_GET["journal"];
} 

// LLAMO LA LIBRERIA DONPDF Y LA CLASE QUE TIENE LOS PROCEDIMIENTOS ALMACENADOS
require_once '../libs/dompdf/autoload.inc.php';
require_once '../model/certificadoDAO.php';
require_once  '../Handler/certificado_data_handler.php';

use Dompdf\Dompdf;
use Dompdf\Options;

try {
  // INSTANCIO UNA CLASE PARA USAR LOS METODOS QUE SE CONECTAN CON LA BD
  $certificado = new certificadoDAO();
  $dataHandler = new DataHandler();

  //COMIENZO A OBTENER EN MEMORIA EL HTML Y LOS DATOS QUE SE ENVIARAN
  ob_start();
  /*OBTENGO LOS DATOS DEL ARTÍCULO */
  $res_title = $certificado->getTitle($id);
  $res_date = $certificado->getDatePublication($id);

  $res_id = $certificado->getIdAuthors($id);
  $array_data_tmp = array();
  $res_vol_num = $certificado->getVol_num($id);

  foreach ($res_id as $i){
    $res_data_author = $certificado->getDataAuthors($i["AUTHOR_ID"]);
    array_push($array_data_tmp, $res_data_author);
  }

  $titleRevista = $dataHandler->getTitleRevista($journal);
  $ISSN = $dataHandler->getISSN($journal);
  $e_ISSN = $dataHandler->getE_ISSN($journal);


  /*ENVIO LOS DATOS AL ARCHIVO HTML/PHP QUE SE VA A RENDERIZAR */
  include "../Handler/certificado.tpl.php";
  /* GUARDO EL ARCHIVO HTML/PHP CON TODOS LOS DATOS ORDENADOS Y ESTILOS */
  $html = ob_get_clean();

  /* COMIENZO A CREAR EL PDF */
  $dompdf = new Dompdf(["isRemoteEnabled" => true]); 
  $dompdf->load_html($html); 
  $dompdf->render(); 
  $dompdf->add_info("Title", "Certificado de Aceptación"); 
  $dompdf->stream("Certificado de Aceptación.pdf", ["Attachment" => 0]); 

} catch (\Throwable $th) {
    echo "Ocurrio un error".$th;
}

?>
