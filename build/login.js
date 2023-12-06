let intentosFallidos = parseInt(localStorage.getItem('intentosFallidos') || 0);
let ultimoIntento = localStorage.getItem('ultimoIntento');
ultimoIntento = ultimoIntento ? new Date(ultimoIntento) : null;

document.addEventListener("DOMContentLoaded", function() {
    verificarTiempo();
});


///  FUNCION VERDFICAR TIEMPO DE ESPERA
function verificarTiempo() {
    if (intentosFallidos >= 3 && ultimoIntento) {
        const ahora = new Date();
        const diferencia = (ahora - ultimoIntento) / 1000 / 60; // Diferencia en minutos

        if (diferencia < 15) {
            document.getElementById("botonIniciarSesion").disabled = true;
            Swal.fire({ icon: "error", title: "Ops! Al parecer debes esperar un momento.", text: "Espera un lapso de 15 min. Para volver a intentar, o bien intente recuperar su contraseña." });
            return false;
        }
    }
    document.getElementById("botonIniciarSesion").disabled = false;
    return true;
}


function login() {
    
        // VERFIICAR TIEMPO DESDE EL ULTIMO INTENTO FALLIDO
        if (!verificarTiempo()) {
            Swal.fire({ icon: "error", title: "Espera Requerida", text: "Debes esperar 15 minutos antes de volver a intentarlo." });
            return;
        }


    const usuarioInput = document.getElementById("user").value;
    const passInput = document.getElementById("pass").value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;




    // Validar si los campos están vacíos
    if (!usuarioInput.trim()) {
        Swal.fire({  icon: "error", title: "Campo Vacío",  text: "Debe ingresar un correo electrónico"  });
        return;
    } else if (!passInput.trim()) {
        Swal.fire({ icon: "error",  title: "Campo Vacío",  text: "Debe ingresar una contraseña"  });
        return;
    } else if (!emailRegex.test(usuarioInput)) {
        Swal.fire({  icon: "error", title: "Error en Datos",  text: "Por favor ingresa una dirección de correo electrónico válida."  });
        return;
    }



    // Asumiendo que tienes una función para hashear la contraseña
    hashPassword(passInput).then(hashedPassInput => {
        db.collection("login")
            .where("user", "==", usuarioInput)
            .where("pass", "==", hashedPassInput)
            .get()
            .then((querySnapshot) => {
                if (!querySnapshot.empty) {
                    // ... manejo del usuario encontrado en la colección principal 
                    const userDoc = querySnapshot.docs[0];
                    const userData = userDoc.data();
                    const userId = userDoc.id;   
                    const userDatax = querySnapshot.docs[0].data();

                    // Establecer indicadores de sesión
                    localStorage.setItem('usuario_logeado', true);
                    localStorage.setItem('userType', userDatax.userType);  
                    localStorage.setItem('user', userDatax.user);  
                    localStorage.setItem('usergym', userDatax.nombregym);  
                    localStorage.setItem('plangym', userDatax.plan);
                    localStorage.setItem('idDoc', userId);  
                    intentosFallidos = 0;
                    ultimoIntento = null;
                    localStorage.setItem('intentosFallidos', intentosFallidos);
                    localStorage.removeItem('ultimoIntento');

                    if (userData.status == 1) { 
                        Swal.fire({ icon: "success",  title: "Bienvenido",  text: userDatax.nombregym + " Disfrute la Experiencia" });
 
                        setTimeout(function() {
                            switch (userData.userType) {
                                case "superAdmin":
                                    window.location.href = "superadmin/index";
                                    break;
                                case "Admin":
                                    window.location.href = "admin/index";
                                    break;
                                case "userNormal":
                                    window.location.href = "userApp/index";
                                    break;
                                default:
                                    Swal.fire({ icon: "error", title: "Lo sentimos.", text: "Rol no reconocido" });
                                    break;
                            }
                        }, 3000); // El tiempo que se muestra el mensaje antes de redirigir
                    } else { 
                        Swal.fire({ icon: "error", title: "Lo sentimos.", text: "Su usuario ha sido desactivado" });
                    }


                } else {
                    // No se encontró en la colección principal, buscar en la subcolección
                    const gymId = "gym1"; // Este ID deberías obtenerlo de tu lógica de aplicación
                    return db.collection("login").doc(gymId).collection("usuarios_gym")
                        .where("user", "==", usuarioInput)
                        .where("pass", "==", hashedPassInput)
                        .get();
                }
            })
            .then((subSnapshot) => {
                if (subSnapshot && !subSnapshot.empty) {
                    // ... manejo del usuario encontrado en la subcolección 
                    const userDoc = subSnapshot.docs[0];
                    const userDatax= userDoc.data();
                    const userId = userDoc.id;  
                    const userDataxx = subSnapshot.docs[0].data();

                    // Establecer indicadores de sesión
                    localStorage.setItem('usuario_logeado', true);
                    localStorage.setItem('userType', userDataxx.userType);  
                    localStorage.setItem('user', userDataxx.user);  
                    localStorage.setItem('usergym', userDataxx.usergym);  
                    localStorage.setItem('plangym', userDataxx.plan);
                    localStorage.setItem('idDoc', userId);  
                    intentosFallidos = 0;
                    ultimoIntento = null;
                    localStorage.setItem('intentosFallidos', intentosFallidos);
                    localStorage.removeItem('ultimoIntento');

                    if (userDatax.status == 1) { 
                        Swal.fire({ icon: "success",  title: "Bienvenido",  text: userDataxx.usergym + " Disfrute la Experiencia" });
 
                        setTimeout(function() {
                            switch (userDatax.userType) {
                                case "superAdmin":
                                    window.location.href = "superadmin/index";
                                    break;
                                case "Admin":
                                    window.location.href = "admin/index";
                                    break;
                                case "userNormal":
                                    window.location.href = "userApp/index";
                                    break;
                                default:
                                    Swal.fire({ icon: "error", title: "Lo sentimos.", text: "Rol no reconocido" });
                                    break;
                            }
                        }, 3000); // El tiempo que se muestra el mensaje antes de redirigir
                    } else { 
                        Swal.fire({ icon: "error", title: "Lo sentimos.", text: "Su usuario ha sido desactivado" });
                    }
                } else if (subSnapshot) {
                    // Usuario no encontrado en ninguna colección
                    intentosFallidos++;
                    ultimoIntento = new Date(); // Actualizar la hora del último intento fallido
                    localStorage.setItem('intentosFallidos', intentosFallidos);
                    localStorage.setItem('ultimoIntento', ultimoIntento);
            
                    if (intentosFallidos >= 3) {
                        document.getElementById("botonIniciarSesion").disabled = true;
                        Swal.fire({ icon: "error", title: "Haz superado el número de intentos", text: "Espera al menos 15 minutos, para volver a intentar. O recupere su contraseña" });
                    } else {
                        Swal.fire({ icon: "error", title: "Error de Acceso", text: "Usuario y/o contraseña incorrectos" });
                    }
                }
            })
            .catch((error) => {
                // Manejo de errores de la base de datos
                Swal.fire({ icon: "error", title: "Error de Acceso", text: "Error al leer el documento: " + error });
            });
    });
}



// Función para calcular el hash SHA-256 de una contraseña
function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);

    return window.crypto.subtle.digest('SHA-256', data).then(buffer => {
        return hexString(buffer);
    });
}

function hexString(buffer) {
    const byteArray = new Uint8Array(buffer);
    let hexString = '';
    byteArray.forEach(byte => {
        hexString += ('00' + byte.toString(16)).slice(-2);
    });
    return hexString;
}



// Llamar a verificarTiempo() cuando se carga la página
verificarTiempo();