<?php
require_once('./bd_conexion.php');

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $id_empleado = $_POST['id_empleado']; // Necesitamos el ID para la edición
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento_identidad = $_POST['documento_identidad'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];  
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    if ($nombre && $apellido && $documento_identidad && $direccion && $telefono) {
        // Valido foto dándole valor nulo por defecto
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            // Valido tipo de imagen y tamaño
            $allowed_types = ['image/jpeg', 'image/png'];
            if (in_array($_FILES['foto']['type'], $allowed_types)) {
                $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
            } else {
                echo "Archivo de foto inválido o demasiado grande.";
                exit();
            }
        }

        // Comprobar si el empleado ya existe (si tiene ID) para actualizar en lugar de insertar
        if ($id_empleado) {
            // Si se proporciona un ID, hacemos una actualización
            $inyectar = $conn->prepare("UPDATE empleados SET nombre=?, apellido=?, documento_identidad=?, direccion=?, email=?, telefono=?, foto=?, estado=? WHERE id_empleado=?");
            // Vincular parámetros
            $inyectar->bind_param("ssisssssi", $nombre, $apellido, $documento_identidad, $direccion, $email, $telefono, $foto, $estado, $id_empleado);
        } else {
            // Si no hay ID, se realiza una inserción
            $inyectar = $conn->prepare("INSERT INTO empleados (nombre, apellido, documento_identidad, direccion, email, telefono, foto, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            // Vincular parámetros
            $inyectar->bind_param("ssisssss", $nombre, $apellido, $documento_identidad, $direccion, $email, $telefono, $foto, $estado);
        }

        if ($inyectar->execute()) {
            echo $nombre, " - Ha sido " . ($id_empleado ? "actualizado" : "agregado") . " exitosamente.";
        } else {
            echo "Error: " . $inyectar->error;
        }

        $inyectar->close();
    } else {
        echo "Ocurrió un error, faltan datos requeridos.";
    }
}