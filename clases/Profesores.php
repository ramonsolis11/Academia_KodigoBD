<?php
require_once "Conexion.php";

class Coach extends Conexion{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $correo;
    protected $materia;
    protected $estado;

    //obtener todos los profesores activos
    public function getProfesores(){
        //llamamos al metodo conectar de la clase conexion
        $pdo = $this->conectar(); //PDO
        //generamos la consulta
        $query = $pdo->query("SELECT coach.*, materia.nombre AS materia FROM coach INNER JOIN materia ON coach.id_materia = materia.id WHERE coach.id_estado = 1");
        //ejecutemos la consulta
        $query->execute(); //[]
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);//arreglo de objetos
        return $resultado;
    }

    //obtener las materias
    public function getMaterias(){
        //llamamos al metodo conectar de la clase conexion
        $pdo = $this->conectar(); //PDO
        //generamos la consulta
        $query = $pdo->query("SELECT id, nombre FROM materia");
        //ejecutemos la consulta
        $query->execute(); //[]
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);//arreglo de objetos
        return $resultado;
    }


}