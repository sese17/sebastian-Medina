<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "control_clientes");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$nombre_completo = $_POST['nombre_completo'];
$telefono = $_POST['telefono'];
$descripcion_equipo = $_POST['descripcion_equipo'];
$detalle_reparacion = $_POST['detalle_reparacion'];

// Insertar los datos en la tabla clientes
$sql_cliente = "INSERT INTO clientes (nombre_completo, telefono) VALUES ('$nombre_completo', '$telefono')";
if ($conexion->query($sql_cliente) === TRUE) {
    $id_cliente = $conexion->insert_id;

    // Insertar los datos en la tabla ordenes_trabajo
    $sql_orden = "INSERT INTO ordenes_trabajo (id_cliente, descripcion_equipo, detalle_reparacion) VALUES ('$id_cliente', '$descripcion_equipo', '$detalle_reparacion')";
    if ($conexion->query($sql_orden) === TRUE) {
        echo "Orden de trabajo creada exitosamente.";
    } else {
        echo "Error al crear la orden de trabajo: " . $conexion->error;
    }
} else {
    echo "Error al guardar los datos del cliente: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Botones Estilizados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .button-container {
            display: flex;
            justify-content: center; /* Centra los botones en la fila */
            gap: 15px; /* Espacio entre los botones */
            margin-top: 20px; /* Espacio superior */
        }
        .btn-custom {
            background-color: #0056b3; /* Color de fondo */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px 20px; /* Espaciado interno */
            font-size: 16px; /* Tamaño de la fuente */
            transition: background-color 0.3s, transform 0.3s; /* Transición suave */
        }
        .btn-custom:hover {
            background-color: #003d7a; /* Color de fondo en hover */
            transform: scale(1.05); /* Efecto de aumento al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="index.php" class="btn btn-custom">Crear Orden</a>
        <a href="buscar_orden.php" class="btn btn-custom">Buscar Orden</a>
    </div>
</body>
</html>