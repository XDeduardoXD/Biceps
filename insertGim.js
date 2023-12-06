function saveGym() {
    // Obtener los valores del formulario
    const userGym = document.getElementById("userGym").value;
    const passGym = document.getElementById("passGym").value;
    const userTypeGym = document.getElementById("userTypeGym").value;
    const statusGym = document.getElementById("statusGym").value;
    const nombreGym = document.getElementById("nombreGym").value;
    const planGym = document.getElementById("planGym").value;
    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

    //Validamos Inputs Vacios
    if (!userGym.trim() || !passGym.trim() || !statusGym.trim() || !nombreGym.trim()) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }


    
    //VERIFICAMOS SI EXISTE REGISTRO
    db.collection('login').where("user", "==", userGym).get()
    .then((querySnapshot) => {
        if (querySnapshot.empty) {
            //VALIDAMOS E INSERTAMOS
            if (validarInputs(nombreGym, userGym, passGym)) {
                hashPassword(passGym).then(hashedPass => {    // Hasheamos e Insertamos si todos estan Bien
                    db.collection('login').add({ user: userGym, pass: hashedPass, userType: userTypeGym, status: statusGym, nombregym: nombreGym, plan: planGym, fechaAdd: formattedDate })
                        .then((docRef) => {
                            Swal.fire({ icon: "success", title: "Gimnasio agregado", text: "Se añadió el Gimnasio, de manera exitosas" }).then(() => {
                                setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/superadmin/usersManager"; }, 1000);
                            });
                        })
                        .catch((error) => {
                            Swal.fire({ icon: "error", title: "Error", text: "Intente nuevamente", error });
                        });
                });
            } else { // Si no todos estan Bien
                Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
            }
        } else {
            // El usuario ya existe, muestra un mensaje de error
            Swal.fire({ icon: "error", title: "Usuario existente", text: "El nombre de usuario ya está en uso. Por favor, elige otro." });
        }
    })
    .catch((error) => {
        Swal.fire({ icon: "error", title: "Error", text: "Error al verificar el usuario:", error });
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



// Función VALIDACION INPUTS
function validarInputs(nombreGym, userGym, passGym) {
    var regexInput1 = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
    var regexInput3 = /^[^' "<>{}]{6,17}$/;

    var esValidoInput1 = regexInput1.test(nombreGym);
    var esValidoInput2 = regexInput2.test(userGym);
    var esValidoInput3 = regexInput3.test(passGym);

    return esValidoInput1 && esValidoInput2 && esValidoInput3;
}


/* function validarInputs(nombreGym, userGym, passGym) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;

    var hasUpperCase = /[A-Z]/.test(passGym); // Al menos una letra mayúscula
    var hasLowerCase = /[a-z]/.test(passGym); // Al menos una letra minúscula
    var hasNumbers = /\d/.test(passGym); // Al menos un número
    var hasNoSpecialChar = /^[a-zA-Z0-9]*$/.test(passGym); // No caracteres especiales

    // Verifica todas las condiciones
    var esValidoInput1 = regexInput1.test(nombreGym);
    var esValidoInput2 = regexInput2.test(userGym);
    var esValidoInput3 = hasUpperCase && hasLowerCase && hasNumbers && hasNoSpecialChar;
    console.log("Nombre Gym:", nombreGym, "Válido:", esValidoInput1);
    console.log("Usuario Gym:", userGym, "Válido:", esValidoInput2);
    console.log("Contraseña:", passGym, "Válido:", esValidoInput3);

    return esValidoInput1 && esValidoInput2 && esValidoInput3;
} */

