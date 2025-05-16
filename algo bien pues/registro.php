<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";       // tu usuario de MySQL
$clave = "123";             // tu contraseña de MySQL
$bd = "usuarios_db";     // nombre de tu base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Capturar datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encriptar la contraseña

// Preparar la consulta
$sql = "INSERT INTO usuarios (nombre, apellido, telefono, email, password) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $telefono, $email, $password);

// Ejecutar e informar
if ($stmt->execute()) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>