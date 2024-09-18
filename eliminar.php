<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'base');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del registro a eliminar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Preparar y ejecutar la consulta de eliminación
    $sql = "DELETE FROM rdiagnostico WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        // Redirigir a la página principal después de eliminar
        header("Location: secretaria.php");
        exit();
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }

    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
