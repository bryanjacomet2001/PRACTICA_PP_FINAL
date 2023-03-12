<?php 
    class DataHandler {

        private $json_data;

        public function __construct() {
            $this->json_data = file_get_contents('http://localhost/PP2/data/data.json');
        }

        public function getTitleRevista($idJournal){
            $datos = json_decode($this->json_data, true);
            $tituloRevista = "";

            foreach($datos as $data){
                if($data['idJournal'] === (int)$idJournal){
                    $tituloRevista = $data["nombreRevista"];
                    break;
                }
            }
            return $tituloRevista;
        }

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
    }
?>

