<?php

    // Conexión a la base de datos
    $host = "localhost";
    $dbname = "ga7aa5";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }

    // Obtener datos de la solicitud
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Realizar acciones según la solicitud, primero registro, sino, inicio de sesión
    if ($action == 'registro') {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Insertar usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)");
        $stmt->execute([$usuario, $contrasena]);
        echo "Registro exitoso";
    } elseif ($action == 'inicio_sesion') {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Verificar credenciales de inicio de sesión
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?");
        $stmt->execute([$usuario, $contrasena]);

        if ($stmt->rowCount() > 0) {
            echo "Autenticación exitosa";
        } else {
            echo "Error en la autenticación";
        }
    }

?>
