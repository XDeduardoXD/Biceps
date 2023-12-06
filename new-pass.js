
const url = window.location.href;
const urlObj = new URL(url);
const token = urlObj.searchParams.get("token");
const coreeoRec = urlObj.searchParams.get("mail");
document.getElementById("user").value = coreeoRec;

function newPass() {
  const usuarioInput = document.getElementById("user").value;
  const pass = document.getElementById("pass").value;

  if (!usuarioInput.trim() || !pass.trim()) {
    Swal.fire({
      icon: "error",
      title: "Campos Vacios.",
      text: "Debe ingresar Usuario y contraseña, para poder reestablecer su Acceso."
    });
    return; // Detiene la ejecución de la función si alguno de los campos está vacío
  }

  // Primero hashear la nueva contraseña
  hashPassword(pass).then(hashedPass => {

      // ENVIAMOS DATOS PARA HASHEAR "TOKEN"
  var formData = new FormData();
  formData.append("user", usuarioInput);  
  fetch("hashAccess.php", {
    method: "POST",
    body: formData,
  })


  .then((response) => response.text()) 
  .then((data) => {
      // su token de URL es la misma que la CREADA
    if (data === token) {
      db.collection("login")
        .where("user", "==", usuarioInput)
        .get()
        .then((querySnapshot) => {
          if (!querySnapshot.empty) {
            // BUSCAR EN COLECCION GENERAL
            const userId = querySnapshot.docs[0].id;
            db.collection("login").doc(userId).update({ pass: hashedPass })
              .then(() => {
                Swal.fire({ icon: "success", title: "Datos Actualizados.", text: "Su acceso ha sido reestablecido, Inicie sesión." })
                  .then(() => { setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/"; }, 1000); });
              })
              .catch((error) => {
                Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar el usuario: " + error });
              });
          } else {
           // BUSCAR EN SUB COLECCION USUARIOS_GYM
            const gymId = "gym1"; // Este ID deberías obtenerlo de tu lógica de aplicación
            db.collection("login").doc(gymId).collection("usuarios_gym")
              .where("user", "==", usuarioInput)
              .get()
              .then((subSnapshot) => {
                if (!subSnapshot.empty) {
                // ACTUALIZAR SI LO HALLA
                  const subUserId = subSnapshot.docs[0].id;
                  db.collection("login").doc(gymId).collection("usuarios_gym").doc(subUserId).update({ pass: hashedPass })
                    .then(() => {
                      Swal.fire({ icon: "success", title: "Datos Actualizados.", text: "Su contraseña ha sido reestablecida, Inicie sesión." })
                        .then(() => { setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/"; }, 1000); });
                    })
                    .catch((error) => {
                      Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar la contraseña en la subcolección: " + error });
                    });
                } else {
                  //  INDICAR QUE NO EXISTE EN NINGUNA COLECCION
                  Swal.fire({ icon: "error", title: "Error", text: "No se encontraron documentos que coincidan con la búsqueda en ninguna colección." });
                }
              })
              .catch((error) => {
                Swal.fire({ icon: "error", title: "Error", text: "Error al realizar la consulta en la subcolección: " + error });
              });
          }
        })
        .catch((error) => {
          Swal.fire({ icon: "error", title: "Error", text: "Error al realizar la consulta: " + error });
        });
    } else {
      Swal.fire({ icon: "error", title: "Token Inválido.", text: "Vuelva a abrir el enlace desde su correo." });
    }
  })
  .catch((error) => {
    Swal.fire({ icon: "error", title: "Error", text: "Error en la solicitud fetch: " + error });
  });

});

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
