<?php
    include 'conexion.php';

    $pdo = new Conexion();

    //Listar usuarios y consultar usuarios
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['usuario']) and isset($_GET['password'])){
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:usuario and password=:password");
            $sql->bindValue(':usuario', $_GET['usuario']);
            $sql->bindValue(':password', $_GET['password']);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $resultado = $sql->fetchAll();

            if (empty($resultado)) {
                header("HTTP/1.1 401 Unauthorized");
                echo "Usuario no registrado";
            } else {
                header("HTTP/1.1 200 Usuario autenticado");
                echo "Usuario registrado";
                echo "\n";
                echo json_encode($resultado);
                exit;
            }        
        }
    }

    //Insertar usuario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO usuarios (usuario, password) VALUES(:usuario, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuario', $_POST['usuario']);
        $stmt->bindValue(':password', $_POST['password']);
        $stmt->execute();
        $idPost = $pdo->lastInsertId();
        if($idPost){
            header("HTTP/1.1 201 Usuario registrado");
            echo "Registro exitoso";
            exit;
        }
    }

    //Si no es ningun metodo
    header("HTTP/1.1 400 Bad Request");
?>