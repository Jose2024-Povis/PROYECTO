<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'base');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar datos en la tabla rdiagnostico
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $paciente_nombre = $_POST['paciente_nombre'];
    $diagnostico = $_POST['diagnostico'];
    $resultado = $_POST['resultado'];
    $created_at = $_POST['created_at'];

    // Consulta SQL para insertar los datos en la tabla rdiagnostico
    $sql = "INSERT INTO rdiagnostico (paciente_nombre, diagnostico, resultado, created_at) 
            VALUES ('$paciente_nombre', '$diagnostico', '$resultado', '$created_at')";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nuevo registro creado exitosamente";
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="doctor.css">
</head>
<body>
    <h2><?php echo $mensaje; ?></h2>
    <a href="doctor.html">Volver</a>
    <form action="cerrar_sesion.php" method="POST">
        <input type="submit" value="Cerrar Sesión">
    </form>
</body>
</html>
