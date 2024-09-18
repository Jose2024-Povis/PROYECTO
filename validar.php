<?php
session_start(); // Iniciar la sesión

// Obtener los datos del formulario
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "base");

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para verificar el usuario y la contraseña
$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contraseña='$contraseña'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_fetch_array($resultado);

// Verificar el rol del usuario
if ($filas) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['id_cargo'] = $filas['id_cargo'];
    
    if ($filas['id_cargo'] == 1) { // Administrador
        header("Location: administrador.php");
        exit();
    } elseif ($filas['id_cargo'] == 2) { // Cliente
        header("Location: paciente.php");
        exit();
    }
    elseif ($filas['id_cargo'] == 3) { // Cliente
        header("Location: doctor.html");
        exit();
    }
    elseif ($filas['id_cargo'] == 4) { // Cliente
        header("Location: secretaria.php");
        exit();
    }
} else {
        // Redirigir a la página de inicio con mensaje de error
        header("Location: index.html?error=1");
        exit();
    }   

// Liberar resultados y cerrar conexión
mysqli_free_result($resultado);
mysqli_close($conexion);
?>