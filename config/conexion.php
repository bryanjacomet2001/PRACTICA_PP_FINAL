<?php 
     class Conexion {
        /* FUNCIÓN PARA ESTABLECER LA CONEXION CON LA BD */
        public static function getConexion(){
        
            $host = 'localhost';
            $user = 'root';
            $clave = '290501';
            $bd = 'ojournal';
            $dsn = 'mysql:host=localhost;dbname='.$bd; 
            $conexion = null;

            try{
                $conexion = new PDO($dsn, $user, $clave);
            }
            catch(Exception $e){
                    die("error " . $e->getMessage());
            }
            return $conexion;
        } 
    }      
?>
       
