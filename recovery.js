

function recoverPassword() {
  const usuarioInput = document.getElementById("user").value;

  if (!usuarioInput.trim()) {
    Swal.fire({ icon: "error", title: "Campo Vacío.", text: "Debe ingresar Usuario para poder validarlo." });
    return; // Detiene la ejecución de la función si alguno de los campos está vacío
  }
  // Accede a Firestore y busca un documento que coincida con las credenciales proporcionadas
  db.collection("login")
    .where("user", "==", usuarioInput)
    .get()
    .then((querySnapshot) => {
      if (!querySnapshot.empty) {

        const userData = querySnapshot.docs[0].data();
        if (userData.status == 1) {

          //Establecemoslo que se enviara a Mail.php
          var formData = new FormData();
          formData.append("mail", usuarioInput);

          fetch("sendMail.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.text())
            .then((data) => {
              Swal.fire({ icon: "info", title: "Respuesta", text: data }); // Esto mostrará la respuesta del archivo PHP en la consola del navegador
              if (data === "Ok") {
                Swal.fire({ icon: "success", title: "Usuario validado.", text: "Revise el correo proporcionado y siga las indicaciones en él, para reestablecer su contraseña." });
              } else {
                Swal.fire({ icon: "error", title: "Eror", text: "Ha sucedido un error al enviar el correo, intente nuevamente." });
              }
            })
            .catch((error) => {
              Swal.fire({ icon: "error", title: "Error", text: "Error en la solicitud fetch: ", error });
            });


        } else {
          Swal.fire({
            icon: 'error', title: 'Oops...', text: 'Este usuario ha sido desactivado!, Intentelo de nuevo en 5 minutos', footer: '<a href="#">Contactese con Administrador</a>'
          })
        }
      } else {
        // Si no se encuentra en la colección "login", busca en la subcolección "usuarios_gym" del documento conocido (por ejemplo, 'gym1')
        const gymId = "gym1"; // Debes obtener este ID de alguna manera, ya sea del usuario o de tu lógica de aplicación
        db.collection("login")
          .doc(gymId)
          .collection("usuarios_gym")
          .where("user", "==", usuarioInput)
          .get()
          .then((subQuerySnapshot) => {
            if (!subQuerySnapshot.empty) {

              const userDataa = subQuerySnapshot.docs[0].data();
              if (userDataa.status == 1) {

                //Establecemoslo que se enviara a Mail.php
                var formData = new FormData();
                formData.append("mail", usuarioInput);

                fetch("sendMail.php", {
                  method: "POST",
                  body: formData,
                })
                  .then((response) => response.text())
                  .then((data) => {
                    Swal.fire({ icon: "info", title: "Respuesta", text: data }); // Esto mostrará la respuesta del archivo PHP en la consola del navegador
                    if (data === "Ok") {
                      Swal.fire({ icon: "success", title: "Usuario validado.", text: "Revise el correo proporcionado y siga las indicaciones en él, para reestablecer su contraseña." });
                    } else {
                      Swal.fire({ icon: "error", title: "Eror", text: "Ha sucedido un error al enviar el correo, intente nuevamente." });
                    }
                  })
                  .catch((error) => { Swal.fire({ icon: "error", title: "Error", text: "Error en la solicitud fetch: ", error }); });


              } else {
                Swal.fire({
                  icon: 'error', title: 'Oops...', text: 'Este usuario ha sido desactivado!, Intentelo de nuevo en 5 minutos', footer: '<a href="#">Contactese con Administrador</a>'
                })
              }
            } else {
              // Usuario no encontrado en ninguna colección
              Swal.fire({ icon: 'error', title: 'Oops...', text: 'Este usuario no existe!, Intentelo de nuevo en 5 minutos' });
            }
          })
          .catch((subError) => {
            Swal.fire({ icon: 'error', title: 'Oops...', text: "Error al leer el documento en la subcolección ", subError });
          });
      }
    })
    .catch((error) => {
      Swal.fire({ icon: 'error', title: 'Oops...', text: 'Error al leer el documento: ', error });
    });
}



