<?php
require_once "Conexion.php";

class Estudiante extends Conexion{
    protected $id;
    protected $nombre;
    protected $direccion;
    protected $carnet;
    protected $bootcamp;
    protected $estado;

    //obtener todos los estudiantes activos
    public function getAll(){
        //llamamos al metodo conectar de la clase conexion
        $pdo = $this->conectar(); //PDO
        //generamos la consulta
        $query = $pdo->query("SELECT estudiante.*, bootcamp.bootcamp FROM estudiante INNER JOIN bootcamp ON estudiante.id_bootcamp = bootcamp.id WHERE estudiante.id_estado = 1");
        //ejecutemos la consulta
        $query->execute(); //[]
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);//arreglo de objetos
        return $resultado;
    }

    //obtener los bootcamps
    public function getBootcamps(){
        //llamamos al metodo conectar de la clase conexion
        $pdo = $this->conectar(); //PDO
        //generamos la consulta
        $query = $pdo->query("SELECT id, bootcamp FROM bootcamp");
        //ejecutemos la consulta
        $query->execute(); //[]
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);//arreglo de objetos
        return $resultado;
    }


    //obtener materia
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

    #registrando al estudiante y el detalle de sus materias
    public function save(){
        //isset - empty
        #condicionamos que los campos del formulario no esten vacios
        if(isset($_POST['nombre'],$_POST['direccion'], $_POST['carnet'], $_POST['bootcamp'], $_POST['materias'])){

            $this->nombre = $_POST['nombre']; //karla
            $this->direccion = $_POST['direccion'];
            $this->carnet = $_POST['carnet'];
            $this->bootcamp = $_POST['bootcamp'];
            $materias = $_POST['materias']; //[]
            $this->estado = 1; //activo

            $pdo = $this->conectar(); //PDO
            $query = $pdo->prepare("INSERT INTO estudiante(nombre, direccion, carnet, id_bootcamp, id_estado) VALUES (?, ?, ?, ?, ?)");
            //bindparams(:name => $this->nombre, :address => $this->direccion)
            $resultado = $query->execute(["$this->nombre","$this->direccion","$this->carnet", "$this->bootcamp", "$this->estado"]);
            //true
            if($resultado){
                $query2 = $pdo->query("SELECT id FROM estudiante ORDER BY id DESC LIMIT 1"); //[]
                $query2->execute(); //["id" => 4]
                $alumno = $query2->fetch(PDO::FETCH_ASSOC);
                //$alumno = ["id" => 4]
                $id_estudiante = $alumno["id"]; //4

                #registrando en la tabla detalle_estudiantes_materias
                for($i = 0; $i < count($materias); $i++){
                    $query3 = $pdo->prepare("INSERT INTO detalle_materia_estudiante(id_estudiante, id_materia) VALUES (?, ?)");
                    //bindparams(:name => $this->nombre, :address => $this->direccion)
                    $resultado = $query3->execute([$id_estudiante, $materias[$i]]);
                }

                #redireccionar (header)
                //header('location: estudiantes_activos.php');

                echo "<script>
                    window.location = 'estudiantes_activos.php'
                </script>";
            }
        }
    }

    #obtener estudiante por ID
    public function getStudentById(){
        if(isset($_POST['id_estudiante'])){
            $this->id = $_POST['id_estudiante'];

            $pdo = $this->conectar();
            $query = $pdo->query("SELECT id,nombre, direccion,carnet FROM estudiante WHERE id = $this->id");
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        }
    }

    #actualizar estudiante
    public function update(){
        if(isset($_POST['nombre'],$_POST['direccion'], $_POST['carnet'], $_POST['id_estudiante'])){

            $this->nombre = $_POST['nombre']; //karla
            $this->direccion = $_POST['direccion'];
            $this->carnet = $_POST['carnet'];
            $this->id = $_POST['id_estudiante'];

            $pdo = $this->conectar(); //PDO
            $query = $pdo->prepare("UPDATE estudiante SET nombre = ?, direccion = ?, carnet = ? WHERE id = ?");
            //bindparams(:name => $this->nombre, :address => $this->direccion)
            $resultado = $query->execute(["$this->nombre","$this->direccion","$this->carnet", $this->id]);

            if($resultado){
                echo "<script>
                    window.location = 'estudiantes_activos.php'
                </script>";
            }else{
                echo "Error, al actualizar el estudiante";
            }
        }
    }

    #metodo para obtener el estado desercion y egresado
    public function estadoByEgresadoDesercion(){
        $pdo = $this->conectar();
        $query = $pdo->query("SELECT * FROM estado WHERE id = 3 OR id = 5");
        $query->execute();
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC); //[]
        return $resultado;
    }

    #metodo para actualizar el estado del estudiante (desercion o egresado)
    public function actualizarEstadoDesercionEgresado(){
        if(isset($_POST['id_estudiante'], $_POST['estado'])){
            $this->id = $_POST['id_estudiante']; //2
            $this->estado = $_POST['estado'];

            $pdo = $this->conectar();
            $query = $pdo->prepare("UPDATE estudiante SET id_estado = ? WHERE id = ?");

            $resultado = $query->execute([$this->estado, $this->id]);
            if($resultado){
                echo "<script>
                    window.location = 'estudiantes_activos.php'
                </script>";
            }else{
                echo "Error, al cambiar el estado del estudiante";
            }
        }
    }

    #metodo que obtiene los estudiantes desertados
    public function getDesertados(){
        //llamamos al metodo conectar de la clase conexion
        $pdo = $this->conectar(); //PDO
        //generamos la consulta
        $query = $pdo->query("SELECT estudiante.*, bootcamp.bootcamp, estado.estado FROM estudiante INNER JOIN bootcamp ON estudiante.id_bootcamp = bootcamp.id INNER JOIN estado ON estudiante.id_estado = estado.id WHERE estudiante.id_estado = 3");
        //ejecutemos la consulta
        $query->execute(); //[]
        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);//arreglo de objetos
        return $resultado;
    }

    #metodo para actualizar el estado del estudiante reubicado
    public function actualizarEstadoReubicado(){
        if(isset($_POST['id_estudiante'], $_POST['estado'])){
            $this->id = $_POST['id_estudiante']; //2
            $this->estado = $_POST['estado'];

            $pdo = $this->conectar();
            $query = $pdo->prepare("UPDATE estudiante SET id_estado = ? WHERE id = ?");

            $resultado = $query->execute([$this->estado, $this->id]);
            if($resultado){
                echo "<script>
                    window.location = 'estudiantes_activos.php'
                </script>";
            }else{
                echo "Error, al cambiar el estado del estudiante";
            }
        }
    }

    #metodo para reubicar al estudiante
    public function reubicarEstudiante($id_estudiante, $nuevoBootcamp) {
        $pdo = $this->conectar();
        $query = $pdo->prepare("UPDATE estudiante SET id_bootcamp = ?, id_estado = 2 WHERE id = ?");
        return $query->execute([$nuevoBootcamp, $id_estudiante]);
    }

    #metodo para obtener los estudiantes reubicados
    public function getEstudiantesReubicados() {
        $pdo = $this->conectar();
        $query = $pdo->query("SELECT estudiante.*, bootcamp.bootcamp FROM estudiante INNER JOIN bootcamp ON estudiante.id_bootcamp = bootcamp.id WHERE estudiante.id_estado = 2");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

# Método para actualizar el estado del estudiante egresado
public function actualizarEstadoEgresado(){
    if(isset($_POST['id_estudiante'], $_POST['estado'])){
        $this->id = $_POST['id_estudiante'];
        $this->estado = $_POST['estado'];

        $pdo = $this->conectar();
        $query = $pdo->prepare("UPDATE estudiante SET id_estado = ? WHERE id = ?");

        $resultado = $query->execute([$this->estado, $this->id]);
        if($resultado){
            echo "<script>
                window.location = 'estudiantes_activos.php'
            </script>";
        }else{
            echo "Error al cambiar el estado del estudiante";
        }
    }
}

# Método para obtener los estudiantes egresados
public function getEgresados() {
    $pdo = $this->conectar();
    $query = $pdo->query("SELECT estudiante.*, bootcamp.bootcamp, estado.estado FROM estudiante INNER JOIN bootcamp ON estudiante.id_bootcamp = bootcamp.id INNER JOIN estado ON estudiante.id_estado = estado.id WHERE estudiante.id_estado = 5");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}



}
