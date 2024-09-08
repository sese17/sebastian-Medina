<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar y Modificar Orden de Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .content-container {
            max-width: 600px; /* Limit the width on large screens */
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }
        .p{
            margin: auto;
        }

        .subheader {
            background-color: #FFA500;
            color: black;
            text-align: center;
            padding: 15px;
            font-style: italic;
            font-weight: bold;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            font-size: 20px;
            margin: auto;
        }

        .footer {
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            font-size: 20px;
        }

        .table th, .table td {
            text-align: left;
            vertical-align: middle;
        }

        /* Custom adjustments for smaller screens */
        @media (max-width: 576px) {
            .header, .subheader, .footer {
                padding: 15px;
            }
            .content-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="content-container">
            <h2 class="text-center">Buscar y Modificar Orden de Trabajo</h2>
            <form action="buscar_orden.php" method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="busqueda" class="form-label">Buscar por Número de Orden, Nombre o Teléfono</label>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['busqueda'])) {
                $busqueda = $_POST['busqueda'];

                // Conexión a la base de datos
                $conexion = new mysqli("localhost", "root", "", "control_clientes");

                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Consulta SQL para buscar por número de orden, nombre o teléfono
                $sql = "SELECT o.id_orden, c.nombre_completo, c.telefono, o.descripcion_equipo, o.detalle_reparacion, o.costo_final
                        FROM ordenes_trabajo o
                        JOIN clientes c ON o.id_cliente = c.id_cliente
                        WHERE o.id_orden = ? OR c.nombre_completo LIKE ? OR c.telefono = ?";

                // Preparar la sentencia
                $stmt = $conexion->prepare($sql);

                // Añadir comodín para búsqueda parcial por nombre
                $busqueda_nombre = '%' . $busqueda . '%';

                // Vincular parámetros
                $stmt->bind_param("iss", $busqueda, $busqueda_nombre, $busqueda);

                // Ejecutar la consulta
                $stmt->execute();
                $resultado = $stmt->get_result();

                // Verificar si se encontraron resultados
                if ($resultado->num_rows > 0) {
                    $fila = $resultado->fetch_assoc();
                    ?>

                    <div class="mt-4">
                        <div class="header rounded">
                                <img src="images/sm - copia.png" alt="Logo de la Empresa">
                        </div>

                        <div class="subheader rounded">
                            <p class="p">Orden de Trabajo</p>
                        </div>

                        <div class="main-content m-2">
                            <div class="row">
                                <div class="col-6">
                                    <strong>CLIENTE:</strong> <?php echo htmlspecialchars($fila['nombre_completo']); ?>
                                </div>
                                <div class="col-6 text-end">
                                    <strong>FECHA:</strong> <?php echo date('Y-m-d'); ?>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <strong>TELÉFONO:</strong> <?php echo htmlspecialchars($fila['telefono']); ?>
                                </div>
                                <div class="col-6 text-end">
                                    <strong>Nº ORDEN :</strong> <?php echo htmlspecialchars($fila['id_orden']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="description mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>DESCRIPCIÓN</th>
                                        <th>PRECIO TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p><strong>Descripción del Equipo:</strong><br><?php echo htmlspecialchars($fila['descripcion_equipo']); ?></p>
                                            <p><strong>Detalle de la Reparación:</strong><br><?php echo htmlspecialchars($fila['detalle_reparacion']); ?></p>
                                        </td>
                                        <td>$ <?php echo htmlspecialchars($fila['costo_final']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <form action="buscar_orden.php" method="POST" class="mt-4">
                            <div class="mb-3">
                                <label for="costo_final" class="form-label">Costo Final</label>
                                <input type="number" step="0.01" class="form-control" id="costo_final" name="costo_final" value="<?php echo htmlspecialchars($fila['costo_final']); ?>" required>
                            </div>
                            <input type="hidden" name="numero_orden" value="<?php echo htmlspecialchars($fila['id_orden']); ?>">
                            <button type="submit" name="actualizar" class="btn btn-success w-100">Actualizar Costo Final</button>
                        </form>

                        <div class="footer mt-4 rounded">
                            <span><strong>DIRECCIÓN:</strong> Yacaré 538, Retiro CABA</span><br>
                            <span><strong>TELÉFONO:</strong> 11 3699-9616</span><br>
                            <span><strong>EMAIL:</strong> sebastiandelmar@gmail.com</span>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<p class='text-danger text-center mt-3'>No se encontraron resultados.</p>";
                }

                if (isset($_POST['actualizar'])) {
                    $costo_final = $_POST['costo_final'];
                    $sql_update = "UPDATE ordenes_trabajo SET costo_final = ? WHERE id_orden = ?";
                    $stmt_update = $conexion->prepare($sql_update);
                    $stmt_update->bind_param("di", $costo_final, $fila['id_orden']);

                    if ($stmt_update->execute()) {
                        echo "<p class='text-success text-center mt-3'>Costo final actualizado exitosamente.</p>";
                    } else {
                        echo "<p class='text-danger text-center mt-3'>Error al actualizar el costo final: " . $stmt_update->error . "</p>";
                    }

                    $stmt_update->close();
                }

                $stmt->close();
                $conexion->close();
            }
            ?>
            <div class="mt-4 d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Crear Orden</a>
                <a href="listado_ordenes.php" class="btn btn-secondary">Listado de Órdenes</a>
            </div>
        </div>
    </div>
</body>
</html>
