<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "productos";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];

// Verificar si el producto existe
$sql_verificar = "SELECT id FROM productos WHERE id = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("s", $id);
$stmt_verificar->execute();
$stmt_verificar->store_result();

if ($stmt_verificar->num_rows === 0) {
    echo "Error: No existe un producto con el ID '$id'.";
} else {
    // Eliminar el producto
    $sql_eliminar = "DELETE FROM productos WHERE id = ?";
    $stmt_eliminar = $conn->prepare($sql_eliminar);
    $stmt_eliminar->bind_param("s", $id);

    if ($stmt_eliminar->execute()) {
        echo "Producto con ID '$id' eliminado exitosamente.";
    } else {
        echo "Error al eliminar el producto: " . $stmt_eliminar->error;
    }

    $stmt_eliminar->close();
}

$stmt_verificar->close();
$conn->close();
?>