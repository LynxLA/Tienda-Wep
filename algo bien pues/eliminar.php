<?php
// eliminar.php

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "usuarios_db";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener teléfono del formulario
$telefono = $_POST['telefono'] ?? '';

if (!empty($telefono)) {
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE telefono = ?");
    $stmt->bind_param("s", $telefono);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Cliente eliminado correctamente.";
        } else {
            echo "No se encontró ningún cliente con ese número de teléfono.";
        }
    } else {
        echo "Error al eliminar: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Teléfono no proporcionado.";
}

$conn->close();
?>
