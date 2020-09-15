<?php
class DB
{
    private $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    private $dns = "mysql:host=localhost; dbname=morosos";
    private $usuario = "dwes";
    private $contrasenia = "abc123.";
    private $conexion = null;

    /* Función que devuelve una conexión a la base de datos */
    public function conectar()
    {



        try {
            $this->conexion = new PDO($this->dns, $this->usuario, $this->contrasenia, $this->opciones);
            return $this->conexion;
        } catch (PDOException $ex) {
            echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
        } finally {
            $this->conexion = null;
        }
    }
}
