<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$clave = "123";
$bd = "usuarios_db";

// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener teléfono desde el formulario
$telefono = $_POST['telefono'] ?? '';

if (!empty($telefono)) {
    // Preparar la consulta
    $sql = "SELECT nombre, apellido, email FROM usuarios WHERE telefono = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nombre, $apellido, $email);
        $stmt->fetch();

        echo "<h2>Datos del usuario</h2>";
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Apellido:</strong> $apellido</p>";
        echo "<p><strong>Email:</strong> $email</p>";
    } else {
        echo "No se encontró ningún usuario con ese número de teléfono.";
    }

    $stmt->close();
} else {
    echo "Número de teléfono no proporcionado.";
}

$conn->close();
?>
