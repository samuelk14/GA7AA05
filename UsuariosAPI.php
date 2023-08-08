<?php
        require_once "UsuariosDB.php";
        class UsuariosAPI {
                public function API(){
                        header('Content-Type: application/JSON');
                        $method = $_SERVER['REQUEST_METHOD'];
                        switch ($method) {
                                case 'GET':
                                        $this->procesaListar();// son funciones creadas en la parte de abajo de este archivo
                                break;
                                case 'POST':
                                        $this->procesaGuardar();// son funciones creadas en la parte de abajo de este archivo
                                break;
                                case 'PUT':
                                        $this->procesaActualizar();// son funciones creadas en la parte de abajo de este archivo
                                break;
                                case 'DELETE':
                                        $this->procesaEliminar();// son funciones creadas en la parte de abajo de este archivo
                                break;
                                default:
                                        echo 'MÉTODO NO SOPORTADO';
                                break;
                        }
                }
                function response($code=200, $status="", $message="") {
                        http_response_code($code);
                        if( !empty($status) && !empty($message) ){
                                $response = array("status" => $status, "message"=>$message);
                                echo json_encode($response, JSON_PRETTY_PRINT);
                        }
                }
                function procesaListar(){
                        if($_GET['action']=='usuarios'){ //se verifica la acción y se verifica que actúe sobre la tabla usuarios
                                $usuariosDB = new UsiariosDB();// aquí se instancia un objeto de la clase usuariosdb
                                if(isset($_GET['id'])){ // se solicita un registro por id
                                        $response = $usuariosDB->dameUnoPorId($_GET['id']);
                                        echo json_encode($response, JSON_PRETTY_PRINT);// aquí se muestra la información en formato json un registro por id
                                } else{
                                        $response = $usuariosDB->dameLista(); // de lo contrario, manda la lista completa
                                        echo json_encode($response, JSON_PRETTY_PRINT); // muestra la lista en formato json
                                }
                        } else{
                                $this->response(400);
                        }
                }
                function procesaGuardar(){
                        if($_GET['action']=='usuarios'){ // se comprueba que trabaja en la tabla usuarios
                                //Decodifica un string de JSON
                                $obj = json_decode( file_get_contents('php://input') );
                                $objArr = (array)$obj;
                                if (empty($objArr)){
                                        $this->response(422,"error","Nothing to add. Check json");
                                } else if(isset($obj->usuario)){
                                        $usuariosDB = new UsuariosDB();
                                        $usuariosDB->guarda( $obj->usuario, $obj->password );
                                        $this->response(200,"success","new record added");
                                } else{
                                        $this->response(422,"error","The property is not defined");
                                }
                        } else{
                                $this->response(400);
                        }
                }
                function procesaActualizar() {
                        if( isset($_GET['action']) && isset($_GET['id']) ){
                                if($_GET['action']=='usuarios'){
                                        $obj = json_decode( file_get_contents('php://input') );
                                        $objArr = (array)$obj;
                                        if (empty($objArr)){
                                                $this->response(422,"error","Nothing to add. Check json");
                                        } else if(isset($obj->usuario)){
                                                $usuariosDB = new UsuariosDB();
                                                $usuariosDB->actualiza($_GET['id'], $obj->usuario, $obj->password );
                                                $this->response(200,"success","Record updated");
                                        } else{
                                                $this->response(422,"error","The property is not defined");
                                        }
                                        exit;
                                }
                        }
                        $this->response(400);
                }
                function procesaEliminar(){
                        if( isset($_GET['action']) && isset($_GET['id']) ){
                                if($_GET['action']=='usuarios'){
                                        $usuariosDB = new UsuariosDB();
                                        $usuariosDB->elimina($_GET['id']);
                                        $this->response(204);
                                        exit;
                                }
                        }
                        $this->response(400);
                }
        }
?>
