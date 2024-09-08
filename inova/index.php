<!DOCTYPE html>
<html>
<head>
    <title>Crear Orden de Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Crear Orden de Trabajo</h2>
    <form action="guardar_orden.php" method="POST">
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="mb-3">
            <label for="descripcion_equipo" class="form-label">Descripción del Equipo</label>
            <textarea class="form-control" id="descripcion_equipo" name="descripcion_equipo" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="detalle_reparacion" class="form-label">Detalle de la Reparación</label>
            <textarea class="form-control" id="detalle_reparacion" name="detalle_reparacion" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Orden</button>
    </form>


    <div class="mt-4">
        <a href="buscar_orden.php" class="btn btn-secondary">Buscar Orden</a>
        <a href="listado_ordenes.php" class="btn btn-secondary">Listado de Órdenes</a>
    </div>
</div>
</body>
</html>
