<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'base');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los datos de la tabla rdiagnostico
$sql = "SELECT * FROM rdiagnostico";
$result = $conn->query($sql);

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Diagnóstico</title>
    <link rel="stylesheet" href="secretaria.css"> <!-- Incluye tu archivo CSS aquí -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            overflow: auto;
        }
        .delete-link {
            color: red;
            text-decoration: none;
        }
        .delete-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Datos de Diagnóstico</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Paciente</th>
                        <th>Diagnóstico</th>
                        <th>Resultado</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['paciente_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['diagnostico']); ?></td>
                            <td><?php echo htmlspecialchars($row['resultado']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <a href="eliminar.php?id=<?php echo urlencode($row['id']); ?>" class="delete-link" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay datos para mostrar.</p>
        <?php endif; ?>

        <a href="cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
</body>
</html>
