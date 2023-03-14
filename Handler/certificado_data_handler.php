<?php 
    require_once '../model/CertificadoDAO.php';
    class CertificadoDataHandler {

        private $json_data;
        private $certificadoDAO;

        public function __construct() {
            $this->json_data = file_get_contents('http://localhost/PP2/data/data.json');
            $this->certificadoDAO = new CertificadoDAO();
        }

        /*Metodo que devuelve el titulo de la revista*/
        public function getMagazineTitle($idJournal){
            $datos = json_decode($this->json_data, true);
            $tituloRevista = "";

            foreach($datos as $data){
                if($data['idJournal'] === (int)$idJournal){
                    $tituloRevista = $data["TtituloRevista"];
                    break;
                }
            }
            return $tituloRevista;
        }

        /*Metodo que devuelve el nombre de la revista*/
        public function getMagazineName($idJournal){
            $datos = json_decode($this->json_data, true);
            $nombreRevista = "";

            foreach($datos as $data){
                if($data['idJournal'] === (int)$idJournal){
                    $nombreRevista = $data["nombreRevista"];
                    break;
                }
            }
            return $nombreRevista;
        }

          /*Metodo que devuelve el nombre de la revista*/
          public function getEditorName($idJournal){
            $datos = json_decode($this->json_data, true);
            $editorRevista = "";

            foreach($datos as $data){
                if($data['idJournal'] === (int)$idJournal){
                    $editorRevista = $data["nombreEditor"];
                    break;
                }
            }
            return $editorRevista;
        }

        /*Metodo que devuelve el ISSN de la revista*/
        public function getISSN($idJournal){
            $datos = json_decode($this->json_data, true);
            $ISSN = "";
            
            foreach($datos as $data){
                if($data['idJournal'] === (int)$idJournal){
                    $ISSN = $data["ISSN"];
                    break;
                }
            }
            return $ISSN;
        }

        /*Metodo que devuelve el E-ISSN de la revista*/
        public function getE_ISSN($idJournal){
            $datos = json_decode($this->json_data, true);
            $ISSN = "";
            
            foreach($datos as $data){
                if($data['idJournal'] === (int)$idJournal){
                    $ISSN = $data["e-ISSN"];
                    break;
                }
            }
            return $ISSN;
        }

        /*Metodo que devuelve el titulo del articulo*/
        public function getArticleTitle($id_submission){
            $title = $this->certificadoDAO->getTitle($id_submission);
            return $title["TITLE"];
        }
        
        /*Metodo que devuelve la fecha de publicacion del articulo*/
        public function getDatePublication($id_submission){
            $date = $this->certificadoDAO->getDatePublication($id_submission);
            return $date;
        }

        /*Metodo que devuelve la fecha actual*/
        public function getDateNow(){
            $dateNow = $this->certificadoDAO->getDateNow();
            return $dateNow;
        }

         /*Metodo que devuelve el numero y volumen del articulo*/
        public function getVolNum($id_submission){
            $volNum = $this->certificadoDAO->getVol_num($id_submission);
            return $volNum;
        }

        /*Metodo que devuelve todos los Ids de los autores de un articulo*/
        public function getIdAuthors($id_submission){
            $IdsAuthors = $this->certificadoDAO->getIdAuthors($id_submission);
            return $IdsAuthors;
        }

          /*Metodo que devuelve todos los datos del autor de un articulo*/
        public function getDataAuthors($id_author){
            $IdAuthor = $this->certificadoDAO->getDataAuthors($id_author);
            return $IdAuthor;
        }
    }
?>

