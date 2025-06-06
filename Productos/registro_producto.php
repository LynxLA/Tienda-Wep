<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "productos";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];

// Insertar en la base de datos
$sql = "INSERT INTO productos (id, nombre, descripcion, precio, cantidad)
        VALUES ('$id', '$nombre', '$descripcion', $precio, $cantidad)";

if ($conn->query($sql) === TRUE) {
  echo "Producto registrado exitosamente.";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
