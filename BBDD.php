<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BBDD
 *
 * @author alumno
 */
class BBDD {

    //put your code here
    private $conexion;
    private $info;
    private $host;
    private $user;
    private $pass;
    private $bd;

    public function __construct($host = "172.17.0.2", $user = "root", $pass = "", $bd = "dwes") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->conexion = new PDO("mysql:dbname=$bd;host=$host", $user, $pass);
    }

    public function __toString() {
        return $this->info;
    }

    public function checkState() {
        if ($this->conexion->errno == 0) {
            $this->info = "Conexión establecida correctamente";
            return 1;
        } else {
            $this->info = "Ha habido un error estableciendo la conexión";
            return 0;
        }
    }

    public function selectQuery($select) {
        $result = $this->conexion->query($select);
        return $this->getValues($result);
    }

    public function modQuery($select) {
        $result = $this->conexion->query($select);
        return $result;
    }

    private function getValues($result) {
        $values = [];
        while ($array = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($values, $array);
        }
        return $values;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }

    /**
     * 
     * @param string $tableName
     * @return array
     */
    public function nombresCampos(string $tableName): array {
        $campos = [];
        $consulta = "SHOW COLUMNS FROM $tableName";

        $r = $this->conexion->query($consulta);
        while ($row = $r->fetch_assoc()) {
            $campos[] = $row['Field'];
        }
        return $campos;
    }

    public function nombresCamposPDO(string $tableName): array {
        $campos = [];
        $consulta = "SHOW COLUMNS FROM $tableName";

        $r = $this->conexion->query($consulta);
        while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
            $campos[] = $row['Field'];
        }
        return $campos;
    }

    function getConexion() {
        return $this->conexion;
    }

    function getInfo() {
        return $this->info;
    }

    function getHost() {
        return $this->host;
    }

    function getUser() {
        return $this->user;
    }

    function getPass() {
        return $this->pass;
    }

    function getBd() {
        return $this->bd;
    }

    function setConexion($conexion) {
        $this->conexion = $conexion;
    }

    function setInfo($info) {
        $this->info = $info;
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setBd($bd) {
        $this->bd = $bd;
    }

}
