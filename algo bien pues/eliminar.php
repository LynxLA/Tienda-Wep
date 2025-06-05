<?php
	header("Content-Type: application/json");
	$conn = mysqli_connect('localhost', 'root', '', 'usuarios_db');
	mysqli_set_charset($conn, 'utf8');
	$method = $_SERVER['REQUEST_METHOD'];
	$results = array();

	if ($method == 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);
		$telefono = $_DELETE['telefono'] ?? '';

		if (!empty($telefono)) {
			$stmt = $conn->prepare("DELETE FROM usuarios WHERE telefono = ?");
			$stmt->bind_param("s", $telefono);
			$stmt->execute();

			if ($stmt->affected_rows > 0) {
				$results['Status']['success'] = true;
				$results['Status']['code'] = 200;
				$results['Status']['description'] = 'Cliente eliminado correctamente.';
			} else {
				$results['Status']['success'] = false;
				$results['Status']['code'] = 404;
				$results['Status']['description'] = 'No se encontró ningún cliente con ese número de teléfono.';
			}

			$stmt->close();
		} else {
			$results['Status']['success'] = false;
			$results['Status']['code'] = 400;
			$results['Status']['description'] = 'Número de teléfono no proporcionado.';
		}
	} else {
		$results['Status']['success'] = false;
		$results['Status']['code'] = 405;
		$results['Status']['description'] = 'Método no permitido. Use DELETE.';
	}

	$json = json_encode($results);
	print_r($json);
?>
