<?php
$host = "localhost";
$usuario = "root";
$contrasena = "123";
$bd = "productos";

$conn = new mysqli($host, $usuario, $contrasena, $bd);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
        echo "<h2>Producto Encontrado</h2>";
        echo "<ul>";
        echo "<li><strong>ID:</strong> " . htmlspecialchars($producto['id']) . "</li>";
        echo "<li><strong>Nombre:</strong> " . htmlspecialchars($producto['nombre']) . "</li>";
        echo "<li><strong>Descripción:</strong> " . htmlspecialchars($producto['descripcion']) . "</li>";
        echo "<li><strong>Precio:</strong> " . number_format($producto['precio'], 2) . "</li>";
        echo "<li><strong>Cantidad:</strong> " . $producto['cantidad'] . "</li>";
        echo "<li><strong>Fecha de Registro:</strong> " . $producto['fecha_registro'] . "</li>";
        echo "</ul>";
    } else {
        echo "<p>No se encontró ningún producto con el ID ingresado.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Debe ingresar un ID válido.</p>";
}

$conn->close();
?>