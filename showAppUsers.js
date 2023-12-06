// Configuración de Firebase (pegar lo que copiaste anteriormente aquí)
const firebaseConfig = {
  apiKey: "AIzaSyCU9v5kAlHZh_eJ8-MLRWiBpPsF24Ligkw",
  authDomain: "prueba-c36ba.firebaseapp.com",
  projectId: "prueba-c36ba",
  storageBucket: "prueba-c36ba.appspot.com",
  messagingSenderId: "759125692065",
  appId: "1:759125692065:web:2b502e6a03e9ad008e2ae0",
};

// Inicializa Firebase usando la versión 'compat'
firebase.initializeApp(firebaseConfig);
const db = firebase.firestore();

function getDocumentsFromSubcollection(
  parentCollection,
  documentId,
  subCollection
) {
  var docId = localStorage.getItem("idDoc");
  var parentRef = db.collection("login").doc(docId);

  // Referencia al tbody de la tabla HTML
  var tableBody = document.getElementById("table-body");

  // Limpiar el contenido actual del tbody
  tableBody.innerHTML = "";

  // Consulta para obtener todos los documentos de la subcolección especificada
  parentRef
    .collection("usuarios_gym")
    .get()
    .then((snapshot) => {
      if (!snapshot.empty) {
        snapshot.forEach((doc) => {
          const data = doc.data();
          const tbody = document
            .getElementById("tabla")
            .getElementsByTagName("tbody")[0];
          const row = tbody.insertRow();

          // Celda para usergym
          const cellId = row.insertCell(0);
          cellId.textContent = data.usergym;

          // Celda para user
          const cellUser = row.insertCell(1);
          cellUser.textContent = data.user || "";

          // Celda para fechaAdd
          const cellPass = row.insertCell(2);
          cellPass.textContent = data.fechaAdd || "";

          // Celda para status
          var estado = data.status == 1 ? "Activo" : "Inactivo";
          const cellStatus = row.insertCell(3);
          cellStatus.textContent = estado;

          const cellPeso = row.insertCell(4);
          cellPeso.textContent = data.peso + " Kg" || "";

          const cellAltura = row.insertCell(5);
          cellAltura.textContent = data.altura + " M/Cm" || "";

          const cellImc = row.insertCell(6);
          cellImc.textContent = data.imc ? parseFloat(data.imc).toFixed(2) : "";

          var Nivel;
          if (data.nivel === "principiante") {
            Nivel = "Principiante";
          } else if (data.nivel === "intermedio") {
            Nivel = "Intermedio";
          } else if (data.nivel === "experto") {
            Nivel = "Experto";
          } else {
            Nivel = "--"; // En caso de que data.nivel no sea ninguno de los anteriores
          }
          const cellNivel = row.insertCell(7);
          cellNivel.textContent = Nivel;

          // Celdas para botones
          // Celdas para botones
          const cellButtons = row.insertCell(8);
          cellButtons.innerHTML =
            `<div style="display: flex; justify-content: space-between;">` +
            `<button style="margin-left:10px; margin-right:10px;" onclick="editarUsuario('${doc.id}')" class="btn btn-primary" >Editar</button>` +
            `<button style="margin-left:10px; margin-right:10px;" onclick="eliminarSubDocumento('${doc.id}')" class="btn btn-primary">Eliminar</button>` +
            `</div>`;
        });
      } else {
        Swal.fire({ icon: "error", title: "Error", text: "No se encontraron documentos en la subcolección." });
      }
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al obtener documentos de la subcolección: ", error });
    });
}

window.onload = getDocumentsFromSubcollection;

// ================= FUNCION GUARDAR CAMBIOS USUARIO
function updateUser() {
  const updateId = document.getElementById("updateId").value;
  const updateName = document.getElementById("updateName").value;
  const updateUser = document.getElementById("updateUser").value;
  const updatePeso = document.getElementById("updatePeso").value;
  const UpdateAltura = document.getElementById("UpdateAltura").value;
  const updateNivelUser = document.getElementById("updateNivelUser").value;
  const updateStatus = document.getElementById("updateStatus").value;
  const imc = updatePeso / (UpdateAltura * UpdateAltura);
  const docId = localStorage.getItem("idDoc");
  const userRef = db
    .collection("login")
    .doc(docId)
    .collection("usuarios_gym")
    .doc(updateId);

  if (!updateName.trim() && !updateUser.trim() && !updatePeso.trim() && !UpdateAltura.trim()) {
    Swal.fire({ icon: "info", title: "Uno o más campos vacíos", text: "Porfavor, ingrese datos en los campos" });
    return;
  } else if (!updateName.trim() || !updateUser.trim() || !updatePeso.trim() || !UpdateAltura.trim()) {
    Swal.fire({ icon: "info", title: "Nombre o Usuario vacío", text: "Porfavor, ingrese datos en los campos" });
    return;
  }

  if (validarInputs(updateName, updateUser, updatePeso, UpdateAltura)) {
    userRef
      .update({ usergym: updateName, user: updateUser, status: updateStatus, peso: updatePeso, altura: UpdateAltura, nivel: updateNivelUser, imc: imc, })
      .then(() => {
        Swal.fire({
          title: "Datos Actualizados.", text: "La contraseña será la misma, previa a los cambios realizados.", icon: "success"
        }).then(() => {
          setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/admin/usersAppManager"; }, 1000);
        });
      })
      .catch((error) => {
        Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar el documento: ", error });
      });
  } else {
    Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
  }
}


function cerrarModal() {
  document.getElementById("miModaledit").style.display = "none";
}

// =================  FUNCION OBTENER DATOS Y AÑADIR A INPUT
function editarUsuario(subDocumentId) {
  document.getElementById("miModaledit").style.display = "block";
  const docId = localStorage.getItem("idDoc");

  const docRef = db
    .collection("login")
    .doc(docId)
    .collection("usuarios_gym")
    .doc(subDocumentId);
  docRef
    .get()
    .then((doc) => {
      if (doc.exists) {
        const data = doc.data();
        document.getElementById("updateId").value = doc.id;
        document.getElementById("updateName").value = data.usergym;
        document.getElementById("updateUser").value = data.user;
        document.getElementById("updatePeso").value = data.peso;
        document.getElementById("UpdateAltura").value = data.altura;
        document.getElementById("updateStatus").value = data.status.toString();
        document.getElementById("updateNivelUser").value = data.nivel.toString();
        document.getElementById("nameEdditing").textContent = data.usergym;
      } else {
        Swal.fire({ icon: "error", title: "Error", text: "No se encontró el documento!" });
      }
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al obtener el documento:", error });
    });
}

// =========================Función para ELIMINAR un documento de una subcolección
function eliminarSubDocumento(subDocumentId) {
  Swal.fire({
    title: "¿Estás seguro de que deseas eliminar este usuario?",
    text: "No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      const docId = localStorage.getItem("idDoc");
      if (!docId) {
        Swal.fire({ icon: "error", title: "Error", text: "Usuario no encontrado" });
        return;
      }
      const subDocRef = db
        .collection("login")
        .doc(docId)
        .collection("usuarios_gym")
        .doc(subDocumentId);

      subDocRef
        .delete()
        .then(() => {
          Swal.fire("Eliminado!", "El documento ha sido eliminado.", "success");
          setTimeout(() => {
            window.location.href =
              "https://biceps.cloudsoft.mx/admin/usersAppManager";
          }, 1000);
        })
        .catch((error) => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un problema al eliminar el documento: " + error,
          });
        });
    }
  });
}

// Función VALIDACION INPUTS
function validarInputs(updateName, updateUser, updatePeso, updateAltura) {
  var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
  var regexInput2 = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
  var regexInput3 = /^(1\.(?:[2-9]|[1-9][0-9])|2(?:\.(?:[0-4][0-9]?|5[0]?))?)$/;
  var regexInput4 = /^(3[5-9]|[4-9]\d|1\d{2}|2[0-4]\d|250)(\.\d{0,2})?$/;

  var esValidoInput1 = regexInput1.test(updateName);
  var esValidoInput2 = regexInput2.test(updateUser);
  var esValidoInput3 = regexInput3.test(updatePeso);
  var esValidoInput4 = regexInput4.test(updateAltura);

  return esValidoInput1 && esValidoInput2 && esValidoInput3 && esValidoInput4;
}
