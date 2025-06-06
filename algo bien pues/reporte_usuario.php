<?php
require('fpdf/fpdf.php');

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "usuarios_db");

// Verifica conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta ejemplo (puedes cambiar esto)
$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
$pdf->Ln(10); // Salto de línea

// Encabezados de tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(30, 10, 'Nombre', 1);
$pdf->Cell(30, 10, 'Apellido', 1);
$pdf->Cell(30, 10, 'Telefono', 1);
$pdf->Cell(80, 10, 'Email', 1);
$pdf->Ln();

// Datos de la tabla
$pdf->SetFont('Arial', '', 12);
while ($fila = $resultado->fetch_assoc()) {
    $pdf->Cell(20, 10, $fila['id'], 1);
    $pdf->Cell(30, 10, $fila['nombre'], 1);
    $pdf->Cell(30, 10, $fila['apellido'], 1);
    $pdf->Cell(30, 10, $fila['telefono'], 1);
    $pdf->Cell(80, 10, $fila['email'], 1);
    $pdf->Ln();
}

// Salida del PDF
$pdf->Output();
?>
