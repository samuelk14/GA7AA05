<?php
    include 'conexion.php';

    $pdo = new Conexion();

    //Listar usuarios y consultar usuarios
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['id'])){
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id=:id");
            $sql->bindValue(':id', $_GET['id']);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($sql->fetchAll());
            exit;

        } else{
            $sql = $pdo->prepare("SELECT * FROM usuarios");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($sql->fetchAll());
            exit;
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
            header("HTTP/1.1 201 Creacion de producto OK");
            echo json_encode($idPost);
            exit;
        }
    }

    //Actualizar usuario
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE usuarios SET usuario=:usuario, password=:password WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->bindValue(':usuario', $_GET['usuario']);
        $stmt->bindValue(':password', $_GET['password']);
        $stmt->execute();
        header("HTTP/1.1 200 OK");
        exit;
    }

    //Eliminar usuario
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM usuarios WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        header("HTTP/1.1 200 OK");
        exit;
    }

    //Si no es ningun metodo
    header("HTTP/1.1 400 Bad Request");
?>