<?php
    include 'conexion.php';

    $pdo = new Conexion();

    //Listar usuarios y consultar usuarios
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['usuario']) and isset($_POST['password'])){
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:usuario and password=:password");
            $sql->bindValue(':usuario', $_POST['usuario']);
            $sql->bindValue(':password', $_POST['password']);
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
                
            }  
            exit;      
        } else{
            //Si no es ningun metodo
            header("HTTP/1.1 400 Bad Request");
            echo "Faltan datos de autenticación o verifique el metodo";
            exit;
        }
    }
    
?>