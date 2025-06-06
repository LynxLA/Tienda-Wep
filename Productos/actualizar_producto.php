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

// Obtener datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];

// Verificar si el producto existe
$sql_verificar = "SELECT id FROM productos WHERE id = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("s", $id);
$stmt_verificar->execute();
$stmt_verificar->store_result();

if ($stmt_verificar->num_rows === 0) {
  echo "Error: No existe un producto con el ID '$id'.";
} else {
  // Actualizar los datos
  $sql_actualizar = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, cantidad = ? WHERE id = ?";
  $stmt_actualizar = $conn->prepare($sql_actualizar);
  $stmt_actualizar->bind_param("ssdss", $nombre, $descripcion, $precio, $cantidad, $id);

  if ($stmt_actualizar->execute()) {
    echo "Producto con ID '$id' actualizado exitosamente.";
  } else {
    echo "Error al actualizar producto: " . $stmt_actualizar->error;
  }

  $stmt_actualizar->close();
}

$stmt_verificar->close();
$conn->close();
?>
