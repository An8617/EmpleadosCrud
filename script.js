
// Función para abrir un modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

// Función para cerrar un modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}


function agregarEmpleado(event) {
    event.preventDefault();

    let nombre = document.getElementById("addName").value;
    let apellido = document.getElementById("addSurName").value;
    let documento_identidad = document.getElementById("addDocument").value;
    let direccion = document.getElementById("addAddress").value;
    let email = document.getElementById("addEmail").value;
    let celular = document.getElementById("addTel").value;
    let fotoElement = document.getElementById("addFoto");
  
    foto = fotoElement.files[0];


    let estado = document.getElementById("addStatus").value;

    let datosFormulario = new FormData();
    datosFormulario.append("nombre", nombre);
    datosFormulario.append("apellido", apellido);
    datosFormulario.append("documento_identidad", documento_identidad);
    datosFormulario.append("direccion", direccion);
    datosFormulario.append("email", email);
    datosFormulario.append("telefono", celular);
    if (foto) {
        datosFormulario.append("foto", foto);
    }
  
    datosFormulario.append("estado", estado);

    fetch('agregarEmpleado.php', { 
        method: 'POST',
        body: datosFormulario
    })
    .then(response => response.text())
    .then(data => {
        //document.querySelector('#addEmployeeModal form').reset(); // Limpiar el formulario después de agregar el empleado por si se agrega otro
        //cerrarModal('addEmployeeModal');
        alert(data)
    })
    
    .catch(error => {
        console.error('Error:', error);
    });
}

function eliminar_empleado(codigo) {
    if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
        fetch('eliminarEmpleado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ codigo: codigo })  // Enviar el código del empleado a eliminar
        })
        .then(response => response.text())
        .then(data => {
            alert(data);  // Mostrar el resultado
            cargarEmpleados();  // Recargar la lista de empleados
        })
        .catch(error => {
            console.error('Error eliminando empleado:', error);
        });
    }
}

