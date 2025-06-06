<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";       // tu usuario de MySQL
$clave = "";          // tu contraseña de MySQL
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
$telefono = $_POST['telefono']; // clave para identificar al usuario
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encriptar la nueva contraseña

// Preparar la consulta de actualización
$sql = "UPDATE usuarios 
        SET nombre = ?, apellido = ?, email = ?, password = ?
        WHERE telefono = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $email, $password, $telefono);

// Ejecutar e informar
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "No se encontró ningún usuario con ese número de teléfono.";
    }
} else {
    echo "Error al actualizar: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>