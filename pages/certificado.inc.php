<?php
// LLAMO LA LIBRERIA DONPDF Y LA CLASE QUE TIENE LOS PROCEDIMIENTOS ALMACENADOS
require_once '../libs/dompdf/autoload.inc.php';
require_once  '../Handler/Certificado_data_handler.php';

// OBTENGO EL SUBMISSION ID DEL ARTICULO y EL JOURNAL_ID
if($_GET){
  $id = $_GET["idSub"];
  $journal = $_GET["journal"];
} 

use Dompdf\Dompdf;
use Dompdf\Options;

try {
  // INSTANCIO UNA CLASE PARA USAR LOS METODOS QUE ME DEVUELVEN LOS DATOS DE LOS ARTICULOS PARA FORMAR EL CERTIFICADO
  $dataHandler = new CertificadoDataHandler();

  //COMIENZO A OBTENER EN MEMORIA EL HTML Y LOS DATOS QUE SE ENVIARAN
  ob_start();
  /*OBTENGO LOS DATOS DEL ARTÍCULO */
  $titleRevista = $dataHandler->getMagazineTitle($journal);
  $nombreRevista = $dataHandler->getMagazineName($journal);
  $nombreEditor = $dataHandler->getEditorName($journal);
  $e_ISSN = $dataHandler->getE_ISSN($journal);
  $titleArticle = $dataHandler->getArticleTitle($id);
  $datePublication = $dataHandler->getDatePublication($id);
  $dateNow = $dataHandler->getDateNow();
  $volNum = $dataHandler->getVolNum($id);
  $idAutors = $dataHandler->getIdAuthors($id);
  $arrayDataTmp = array();

  foreach ($idAutors as $i) {
    $dataAuthor = $dataHandler->getDataAuthors($i["AUTHOR_ID"]);
    array_push($arrayDataTmp, $dataAuthor);
  }

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
