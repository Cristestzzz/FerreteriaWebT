document.addEventListener('DOMContentLoaded', init);
function init() {

    const formularioArchivos = document.querySelector("#formulario-admin");
    if(formularioArchivos !== null){
        formularioArchivos.addEventListener('submit', function (e) {
            e.preventDefault();

            let datos = new FormData(formularioArchivos);

            if (isValidRegisterData(datos.get("tipoAccion"), datos.get("tipoOpcion"))) {
                mostrarNotificacion("Datos no válidos", "error");
                return;
            }

            fetch(`inc/modelos/modelo-${datos.get("tipoOpcion")}.php`, {
                method: 'POST',
                cache: "no-cache",  // Opcional
                body: datos
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    let respuesta = data.respuesta;
                    let accion = data.accion;

                    if (respuesta === "exito") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Creado correctamente',
                            showConfirmButton: false,
                            heightAuto: false,
                            timer: 1200
                        }).then(() => {
                            if(accion === "editar"){
                                window.location.href = `${datos.get("tipoOpcion")}-lista.php`
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hubo un error!',
                            showConfirmButton: false,
                            heightAuto: false,
                            timer: 1500
                        })
                    }
                })
        })
    }

    const btnBorrar = document.querySelectorAll(".btn-borrar");
    btnBorrar.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esto es irreversible!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    let datos = new FormData();
                    datos.append("id_registro", btn.getAttribute("id_registro"));
                    datos.append("tipoAccion", "borrar");

                    fetch(`inc/modelos/modelo-${btn.getAttribute("tipoOpcion")}.php`, {
                        method: 'POST',
                        body: datos
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            let respuesta = data.respuesta;
                            if (respuesta === "exito") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    showConfirmButton: false,
                                    heightAuto: false,
                                    timer: 1000
                                })
                                btn.parentElement.parentElement.remove();

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Hubo un error!!',
                                    showConfirmButton: false,
                                    heightAuto: false,
                                    timer: 1500
                                })
                            }
                        })
                }
            })
        })
    })

    const btnCerrarSesion = document.querySelector("#btnCerrarSesion");
    btnCerrarSesion.addEventListener("click", function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del enlace
    
        let datos = new FormData();
        datos.append("tipoAccion", "loginOut"); // Agregar la acción de cierre de sesión
    
        fetch(`inc/modelos/modelo-acceso.php`, {
            method: 'POST',
            body: datos
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            let respuesta = data.respuesta;
    
            if (respuesta === "exito") {
                Swal.fire({
                    icon: 'success',
                    title: 'Cerrando Sesión...',
                    showConfirmButton: false,
                    timer: 1200,
                    heightAuto: false
                }).then(() => window.location.replace(`login.php`)); // Redirigir a login.php
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error...',
                    showConfirmButton: false,
                    timer: 1500,
                    heightAuto: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Hubo un error en la conexión...',
                showConfirmButton: false,
                timer: 1500,
                heightAuto: false
            });
        });
    });

    function isValidRegisterData(accion, opcion) {
        if(opcion === "usuarios"){
            let inputName = document.querySelector("#input-nombre").value;
            let inputPassword = document.querySelector("#input-password").value;
            let inputCorreo = document.querySelector("#input-correo").value;
            let expresionRegular = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if(accion === "editar"){
                return inputName.trim() === "" || !expresionRegular.test(inputCorreo);
            }
            return inputName.trim() === "" || inputPassword.trim() === "" || !expresionRegular.test(inputCorreo);

        } else if(opcion === "productos") {
            let inputName = document.querySelector("#input-nombre").value;
            let inputPrecio = document.querySelector("#input-precio").value;
            let selectCategoria = document.querySelector("#select-categoria").value;
            let inputStock = document.querySelector("#input-stock").value; // Validación de stock

            return inputName.trim() === "" || inputPrecio === "0" || selectCategoria === "0" || inputStock.trim() === ""; // Validar stock

        } else if(opcion === "categorias") {
            let inputName = document.querySelector("#input-nombre").value;
            return inputName.trim() === "";
        }
    }

    // Notificación en pantalla
    function mostrarNotificacion(mensaje, clase) {
        const notificacion = document.createElement("div");
        notificacion.classList.add(clase, "notificacion", "sombra");
        notificacion.textContent = mensaje;

        main = document.querySelector("main");
        main.appendChild(notificacion)

        // Ocultar y mostrar la notificación
        notificacion.classList.add("visible");
        setTimeout(() => {
            notificacion.classList.remove("visible");
            setTimeout(() => {
                notificacion.remove();
            }, 500);
        }, 2000);
    }
}