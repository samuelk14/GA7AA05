<?php
    include 'conexion.php';

    $pdo = new Conexion();


    //Insertar usuario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['usuario']) and isset($_POST['password'])){
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
    }

    //Si no es ningun metodo
    header("HTTP/1.1 400 Bad Request");
?>