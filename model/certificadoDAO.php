<?php
    require '../config/conexion.php';

    class CertificadoDAO{
        private $con;

        public function __construct(){
            $this->con = Conexion::getConexion();
        }

        /* METODO PARA OBTENER EL TITULO DE LA PUBLICACION */
        public function getTitle($id_submission){
            $sql = "CALL SP_GET_TITLE_PUBLICATION ('$id_submission')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultados;
        }

        /* METODO PARA OBTENER LA FECHA DE PUBLICACION */  
        public function getDatePublication($id_submission){
            $sql = "CALL SP_GET_DATE_PUBLICATION ('$id_submission')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultados;
        }

        /* METODO PARA OBTENER LA FECHA ACTUAL */  
        public function getDateNow(){
            $sql = "CALL SP_CERTIFICATE_GENERATION_DATE";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultados;
        }

        /* METODO PARA OBTENER LOS ID DE LOS AUTORES */
        public function getIdAuthors($id_submission){
            $sql = "CALL SP_GET_AUTHORS('$id_submission')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        }

        /* METODO PARA OBTENER LOS DATOS DEL AUTOR */
        public function getDataAuthors($id_authors){
            $sql = "CALL SP_GET_AUTHORS_DATA ('$id_authors')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        }

        /* METODO PARA OBTENER EL VOLUMEN Y EL NUMERO DE LA PUBLICACION */
        public function getVol_num($id_submission)
        {
            $sql = "CALL SP_GET_NUM_VOLUM ('$id_submission')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultados;
        }
        
        /* METODO PARA FILTRAR POR TITULO */
        public function getDataFilterTitle($article_title){
            $sql = "CALL SP_GET_FILTER_TITLE('%".$article_title."%')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        }

        /* METODO PARA FILTRAR POR USERNAME */
        public function getDataFilterUserName($userName){
            $sql = "CALL SP_GET_FILTER_USERNAME('%".$userName."%')";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
        
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        }
    }
?>