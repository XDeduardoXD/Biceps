function saveUser() {
    const userUser = document.getElementById("userUser").value;
    const passUser = document.getElementById("passUser").value;
    const userTypeUser = document.getElementById("userTypeUser").value;
    const statusUser = document.getElementById("statusUser").value;
    const nombreUser = document.getElementById("nameUser").value;
    const pesoUser = document.getElementById("pesoUser").value;
    const alturaUser = document.getElementById("alturaUser").value;
    const imc = pesoUser / (alturaUser * alturaUser);
    const nivelUser = document.getElementById("nivelUser").value;

    var user = localStorage.getItem('user');
    var docId = localStorage.getItem('idDoc');
    var namelogued = localStorage.getItem('usergym');
    var planGym = localStorage.getItem('plangym');
    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

        //Validamos Maximos registros Por Plan
    const LIMITE_USUARIOS_START = 5;
    const LIMITE_USUARIOS_PLUS = 7;
    let limiteDeUsuarios; 
    if (planGym === 'Biceps Start') {
        limiteDeUsuarios = LIMITE_USUARIOS_START;
    } else if (planGym === 'Biceps Plus') {
        limiteDeUsuarios = LIMITE_USUARIOS_PLUS;
    } else { 
        Swal.fire({ icon: "error", title: "Plan desconocido", text: "Contate a CloudSoft, para Resolver su problema" }); 
    }

    //Validamos Inputs Vacios
    if (!userUser.trim() || !passUser.trim() || !statusUser.trim() || !nombreUser.trim() || !pesoUser.trim() || !alturaUser.trim() || !nivelUser.trim()) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }

 
    if (validarInputsx(nombreUser, userUser, passUser, alturaUser, pesoUser)) {
        hashPassword(passUser).then(hashedPass => {
            // Datos que quieres añadir en el nuevo subdocumento
            var newSubDocumentData = {
                usergym: nombreUser,
                user: userUser,
                pass: hashedPass,
                status: statusUser,
                peso: pesoUser,
                altura: alturaUser,
                nivel: nivelUser,
                imc: imc,
                userType: userTypeUser,
                fechaAdd: formattedDate
            };



            // Referencia a la colección 'login'
            var loginRef = db.collection('login');

            // Buscar documento con user igual a usuarioInput
            loginRef.where("user", "==", user).get()
                .then((querySnapshot) => {
                    if (!querySnapshot.empty) {
                        // Si existe, obtener el primer documento que coincida
                        var userDocRef = querySnapshot.docs[0].ref; // Referencia al documento


                        


                        
            // Contar los registros existentes en la subcolección 'usuarios_gym'
            userDocRef.collection("usuarios_gym").where("user", "==", userUser).get()
                .then((userSnapshot) => {
                    if (userSnapshot.empty) {
                        // Si no existe ningun usuario con ese nombre, continuar con la lógica para agregar uno nuevo
                        userDocRef.collection("usuarios_gym").get()
                            .then((subSnapshot) => {
                                // Verificar si se ha alcanzado el límite de usuarios
                                if (subSnapshot.size >= limiteDeUsuarios) {
                                    Swal.fire({ icon: "error", title: "Límite alcanzado", text: `El plan ${planGym} solo permite hasta ${limiteDeUsuarios} usuarios.`,
                                    footer: '<a href="https://cloudsoft.mx/" target="_blank">Solicitar Nuevo Plan</a>' });
                                } else {
                                    // Si no se ha alcanzado el límite, añadir el nuevo usuario
                                    userDocRef.collection("usuarios_gym").add(newSubDocumentData)
                                        .then((docRef) => {
                                            Swal.fire({ icon: "success", title: "Dato Insertado", text: "Se añadió el usuario de manera exitosa." }).then(() => {
                                                setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/admin/usersAppManager"; }, 1000);
                                            });
                                        })
                                        .catch((error) => {
                                            Swal.fire({ icon: "error", title: "Error", text: "Intente nuevamente", error });
                                        });
                                }
                            })
                            .catch((error) => {
                                Swal.fire({ icon: "error", title: "Error", text: "No se pudo contar los usuarios existentes.", error });
                            });
                    } else {
                        // Si ya existe un usuario con ese nombre, mostrar un mensaje de error
                        Swal.fire({ icon: "error", title: "Usuario existente", text: "Ya existe un usuario con ese correo. Por favor, elige otro." });
                    }
                })
                .catch((error) => {
                    Swal.fire({ icon: "error", title: "Error", text: "Error al buscar el nombre de usuario existente.", error });
                });


 

                    } else { 
                        Swal.fire({ icon: "error", title: "Ocurrio un Error", text: "No se encontró un documento con el usuario" });
                    }
                })
                .catch((error) => {
                    Swal.fire({ icon: "error", title: "Ocurrio un Error", text: "Intente Nuevamente." }); 
                });


        });
    }else{
        Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
    }
}




// Función para calcular el hash SHA-256 de una contraseña
function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password); // Convierte la contraseña a un ArrayBuffer

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
function validarInputsx(nombreUser, userUser, passUser, alturaUser, pesoUser) {
    var regexInput1 = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
                    

    var regexInput2 = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
    var regexInput3 = /^[^' "<>{}]{6,17}$/;
    var regexInput4 = /^(1\.(?:[2-9]|[1-9][0-9])|2(?:\.(?:[0-4][0-9]?|5[0]?))?)$/;
    var regexInput5 = /^(3[5-9]|[4-9]\d|1\d{2}|2[0-4]\d|250)(\.\d{0,2})?$/;


    var esValidoInput1 = regexInput1.test(nombreUser);
    var esValidoInput2 = regexInput2.test(userUser);
    var esValidoInput3 = regexInput3.test(passUser);
    var esValidoInput4 = regexInput4.test(alturaUser);
    var esValidoInput5 = regexInput5.test(pesoUser);

    return esValidoInput1 && esValidoInput2 && esValidoInput3 && esValidoInput4 && esValidoInput5;
}
 