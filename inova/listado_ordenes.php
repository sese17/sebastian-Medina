<!DOCTYPE html>
<html>
<head>
    <title>Listado de Órdenes de Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Listado de Órdenes de Trabajo</h2>
    
    <?php
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "control_clientes");

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consultar todas las órdenes de trabajo
    $sql = "SELECT o.id_orden, c.nombre_completo, o.descripcion_equipo
            FROM ordenes_trabajo o
            JOIN clientes c ON o.id_cliente = c.id_cliente";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Número de Orden</th><th>Nombre del Cliente</th><th>Descripción del Equipo</th></tr></thead>";
        echo "<tbody>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['id_orden']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre_completo']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['descripcion_equipo']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-danger'>No hay órdenes de trabajo registradas.</p>";
    }

    // Cerrar conexión
    $conexion->close();
    ?>

<div class="mt-4">
        <a href="index.php" class="btn btn-secondary">Crear Orden</a>
        <a href="buscar_orden.php" class="btn btn-secondary">Buscar Orden</a>
    </div>
</div>
</body>
</html>
