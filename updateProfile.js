function updateProfile() {
    const myId = document.getElementById("myId").value;  
    const myName = document.getElementById("myName").value;
    const myUser = document.getElementById("myUser").value;  
    const myPass = document.getElementById("myPass").value;  
  
    const userRef = db.collection("login").doc(myId);
   

  // Validar si el Usuario o Nombre estan vacios
      if (!myName.trim() && !myUser.trim()) {
          Swal.fire({ icon: "info", title: "Uno o más campos vacíos", text: "Porfavor, ingrese datos en los campos" });
          return;
        }else if (!myName.trim() || !myUser.trim()){
          Swal.fire({ icon: "info", title: "Nombre o Usuario vacío", text: "Porfavor, ingrese datos en los campos" });
          return;
      }

  

      if (validarInputs(myName, myUser, myPass)) {
        hashPassword(myPass).then(hashedPass => { 

            let updateData = {  nombregym: myName,  user: myUser };
            if (myPass !== "") {  updateData.pass = hashedPass;    }


        userRef
          .update(updateData)
          .then(() => {
            Swal.fire({
              title: "Datos Actualizados.", text: "La contraseña será la misma, previa a los cambios realizados.", icon: "success",  }).then(() => {
              setTimeout(() => {  window.location.href = "https://biceps.cloudsoft.mx/superadmin/"; }, 1000);
            });   
          })
          .catch((error) => {
            
          Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar el documento: ", error });
          });

        });
      }else {  
        Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
    }

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
function validarInputs(myName, myUser, myPass) {
  var regexInput1 = /^[a-zA-Z0-9. ]{3,30}$/
  var regexInput2 = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
  var regexInput3 = /^[^' "<>{}]*$/


  var esValidoInput1 = regexInput1.test(myName);
  var esValidoInput2 = regexInput2.test(myUser);
  var esValidoInput3 = regexInput3.test(myPass);

  return esValidoInput1 && esValidoInput2 && esValidoInput3;
}
    