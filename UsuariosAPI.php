<?php
    // Datos de conexión a la base de datos
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "caso"; 

    try {
            // Crear una nueva instancia de la clase PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Configurar el modo de error para que PDO lance excepciones en caso de error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            echo "Conexión exitosa"; 
    } 
    catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
    }
?>
