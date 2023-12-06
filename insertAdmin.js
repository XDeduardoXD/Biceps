function saveAdmin() {
    // Obtener los valores del formulario
    const userAdmin = document.getElementById("userAdmin").value;
    const passAdmin = document.getElementById("passAdmin").value;
    const userTypeAdmin = document.getElementById("userTypeAdmin").value;
    const statusAdmin = document.getElementById("statusAdmin").value;
    const nombreAdmin = document.getElementById("nameAdmin").value;
    const planA = '';

    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

    //Validamos Inputs Vacios
    if (!userAdmin.trim() || !passAdmin.trim() || !statusAdmin.trim() || !nombreAdmin.trim()) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }
    

    //VERIFICAMOS SI EXISTE REGISTRO
    db.collection('login').where("user", "==", userAdmin).get()
    .then((querySnapshot) => {
        if (querySnapshot.empty) {
            //VALIDAMOS E INSERTAMOS
            if (validarInputsAdmin(nombreAdmin, userAdmin, passAdmin)) {
                hashPassword(passAdmin).then(hashedPass => {    // Hasheamos e Insertamos si todos estan Bien
                    db.collection('login').add({ user: userAdmin,pass: hashedPass, userType: userTypeAdmin,status: statusAdmin,nombregym: nombreAdmin, fechaAdd: formattedDate,plan:planA})
                    .then((docRef) => {
                        Swal.fire({ icon: "success", title: "Administrador agregado", text: "Se añadió el Administrador, de manera exitosa" }).then(() => {
                            setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/superadmin/usersManager"; }, 1000);
                        });
                        })
                        .catch((error) => {
                            Swal.fire({ icon: "error", title: "Error", text: "Intente nuevamente", error });
                        });
                });
            } else { 
                Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
            }
        } else {
            // El usuario ya existe, muestra un mensaje de error
            Swal.fire({ icon: "error", title: "Usuario existente", text: "El nombre de usuario ya está en uso. Por favor, elige otro." });
        }
    })
    .catch((error) => {
        Swal.fire({ icon: "error", title: "Error", text: "Error al verificar el usuario", error });
    });

}



// HASHEAMOS
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


// Función VALIDACION TIPO DE TEXTO
function validarInputsAdmin(nombreAdmin, userAdmin, passAdmin) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
    var regexInput3 = /^[^' "<>{}]{6,17}$/;

    var esValidoInput1 = regexInput1.test(nombreAdmin);
    var esValidoInput2 = regexInput2.test(userAdmin);
    var esValidoInput3 = regexInput3.test(passAdmin);

    return esValidoInput1 && esValidoInput2 && esValidoInput3;
}