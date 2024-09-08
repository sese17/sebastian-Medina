<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "control_clientes");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$numero_orden = $_POST['numero_orden'];
$costo_final = $_POST['costo_final'];

// Actualizar el costo final en la tabla ordenes_trabajo
$sql = "UPDATE ordenes_trabajo SET costo_final = ? WHERE id_orden = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("di", $costo_final, $numero_orden);

if ($stmt->execute()) {
    echo "Costo final actualizado exitosamente.";
} else {
    echo "Error al actualizar el costo final: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conexion->close();
?>
