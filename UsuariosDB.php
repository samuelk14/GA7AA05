<?php
    class UsuariosDB {
        protected $mysqli;
        const LOCALHOST = 'localhost'; 
        const USER = 'root';
        const PASSWORD = '';
        const DATABASE = 'caso';
        /**
        * Constructor de clase Inicializa la variable mysqli
        */
        public function __construct() {
            try{
                $this->mysqli = new mysqli(self::LOCALHOST,
                self::USER, self::PASSWORD, self::DATABASE);
            }catch (mysqli_sql_exception $e){
                http_response_code(500);
                exit;
            }
        }
        public function dameUnoPorId($id=0){ //función que retorna un registro por medio de una id
            $stmt = $this->mysqli->prepare("SELECT * FROM usuarios WHERE id=? ; "); // se prepara la consulta con prepare por medio de la conexión que tenemos
            $stmt->bind_param('i', $id); // en lugar de la interrogación, coloque el valor de la variable id
            $stmt->execute();
            $result = $stmt->get_result();
            $usuario = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $usuario;
        }
        public function dameLista(){ //esta función retorna una lista
            $result = $this->mysqli->query('SELECT * FROM usuarios');
            $usuarios = $result->fetch_all(MYSQLI_ASSOC); //aquí se ejecuta la consulta
            $result->close();
            return $usuarios;
        }
        public function guarda($usuario, $password){ //esta función guarda un registro
            $stmt = $this->mysqli->prepare("INSERT INTO usuarios(usuario, password) VALUES(?, ?)");
            $stmt->bind_param('ssi', $usuario, $password);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        public function elimina($id=0) { //esta función elimina un registro
            $stmt = $this->mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->bind_param('i', $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        public function actualiza($id, $usuario, $password){ //esta función actualiza un registro
            if($this->verificaExistenciaPorId($id)){
                $stmt = $this->mysqli->prepare("UPDATE usuarios SET usuario=?, password=? WHERE id = ?");
                $stmt->bind_param('ssii', $usuario, $password, $id);
                $r = $stmt->execute();
                $stmt->close();
                return $r;
            }
            return false;
        }
        public function verificaExistenciaPorId($id){//esta función verifica que exista un registro por id
            $stmt = $this->mysqli->prepare("SELECT * FROM usuarios WHERE ID=?");
            $stmt->bind_param("i", $id);
            if($stmt->execute()){
                $stmt->store_result();
                if ($stmt->num_rows == 1){
                    return true;
                }
            }
            return false;
        }
    }
?>
