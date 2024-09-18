<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador</title>
    <link rel="stylesheet" type="text/css" href="administrador.css">
</head>
<body>
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Sin contraseña
$dbname = "base";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para eliminar usuario
if (isset($_GET['eliminar_id'])) {
    $eliminar_id = $_GET['eliminar_id'];
    $sql = "DELETE FROM usuarios WHERE id = $eliminar_id";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado exitosamente";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
}

// Función para crear un nuevo usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $id_cargo = $_POST['id_cargo'];

    $sql = "INSERT INTO usuarios (nombre, usuario, contraseña, id_cargo) 
            VALUES ('$nombre', '$usuario', '$contraseña', '$id_cargo')";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo usuario creado exitosamente";
    } else {
        echo "Error al crear el usuario: " . $conn->error;
    }
}

// Mostrar la lista de usuarios
$sql = "SELECT u.id, u.nombre, u.usuario, u.contraseña, c.descripcion AS cargo 
        FROM usuarios u
        INNER JOIN cargo c ON u.id_cargo = c.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Contraseña</th><th>Cargo</th><th>Acción</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["usuario"] . "</td>";
        echo "<td>" . $row["contraseña"] . "</td>";
        echo "<td>" . $row["cargo"] . "</td>";
        echo "<td>
            <a href='administrador.php?eliminar_id=" . $row["id"] . "'>Eliminar</a>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay usuarios registrados.";
}
?>

<!-- Formulario para crear un nuevo usuario -->
<h2>Crear un nuevo usuario</h2>
<form method="post" action="">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br>
    <label for="usuario">Usuario:</label><br>
    <input type="text" id="usuario" name="usuario" required><br>
    <label for="contraseña">Contraseña:</label><br>
    <input type="password" id="contraseña" name="contraseña" required><br>
    <label for="id_cargo">Cargo:</label><br>
    <select id="id_cargo" name="id_cargo" required>
        <?php
        // Obtener los cargos desde la base de datos
        $sql = "SELECT id, descripcion FROM cargo";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["descripcion"] . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Crear Usuario">
</form>

<!-- Enlace para cerrar sesión -->
<p><a href="cerrar_sesion.php">Cerrar sesión</a></p>

<?php
$conn->close();
?>
</body>
</html>