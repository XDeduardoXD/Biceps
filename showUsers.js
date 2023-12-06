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

//=========== FUNCION CARGAR DATOS
function cargarDatos() {
  db.collection("login")
    .get()
    .then((querySnapshot) => {
      const tbody = document
        .getElementById("tabla")
        .getElementsByTagName("tbody")[0];
      querySnapshot.forEach((doc) => {
        const data = doc.data();

        const row = tbody.insertRow();

        const cellId = row.insertCell(0);
        cellId.textContent = data.nombregym;

        const cellUser = row.insertCell(1);
        cellUser.textContent = data.user;

        const cellPass = row.insertCell(2);
        cellPass.textContent = data.fechaAdd;

        const cellType = row.insertCell(3);
        cellType.textContent = data.userType;

        const cellButtons = row.insertCell(4);
        cellButtons.innerHTML =
          `<button style="margin-left:10px; margin-right:10px" onclick="editarUsuario('${doc.id}')" class="btn btn-primary">Editar</button>` +
          `<button style="margin-left:10px; margin-right:10px" onclick="eliminarUsuario('${doc.id}')" class="btn btn-primary">Eliminar</button>`;

        var estado;
        if (data.status == 1) {
          estado = "Activo";
        } else {
          estado = "Inactivo";
        }

        const cellStatus = row.insertCell(4);
        cellStatus.textContent = estado;

        const cellPlan = row.insertCell(6);
        cellPlan.textContent = data.plan;
      });
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al obtener documentos: ", error });
    });
}

function cargarDatosGral() {
  db.collection("login")
    .get()
    .then((querySnapshot) => {
      const tbody = document
        .getElementById("tabla")
        .getElementsByTagName("tbody")[0];

      while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
      }

      querySnapshot.forEach((doc) => {
        const data = doc.data();

        const row = tbody.insertRow();

        const cellId = row.insertCell(0);
        cellId.textContent = data.nombregym;

        const cellUser = row.insertCell(1);
        cellUser.textContent = data.user;

        const cellPass = row.insertCell(2);
        cellPass.textContent = data.fechaAdd;

        const cellType = row.insertCell(3);
        cellType.textContent = data.userType;

        const cellButtons = row.insertCell(4);
        cellButtons.innerHTML =
          `<button style="margin-left:10px; margin-right:10px" onclick="editarUsuario('${doc.id}')" class="btn btn-primary">Editar</button>` +
          `<button style="margin-left:10px; margin-right:10px" onclick="eliminarUsuario('${doc.id}')" class="btn btn-primary">Eliminar</button>`;

        var estado;
        if (data.status == 1) {
          estado = "Activo";
        } else {
          estado = "Inactivo";
        }

        const cellStatus = row.insertCell(4);
        cellStatus.textContent = estado;

        const cellPlan = row.insertCell(6);
        cellPlan.textContent = data.plan;
      });
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al obtener documentos: ", error });
    });
}

function cargarDatosSuperAdmin() {
  db.collection("login")
    .get()
    .then((querySnapshot) => {
      const tbody = document
        .getElementById("tabla")
        .getElementsByTagName("tbody")[0];


      while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
      }

      querySnapshot.forEach((doc) => {
        const data = doc.data();

        if (data.userType === "superAdmin") {
          const row = tbody.insertRow();

          const cellId = row.insertCell(0);
          cellId.textContent = data.nombregym;

          const cellUser = row.insertCell(1);
          cellUser.textContent = data.user;

          const cellPass = row.insertCell(2);
          cellPass.textContent = data.fechaAdd;

          const cellType = row.insertCell(3);
          cellType.textContent = data.userType;

          const cellButtons = row.insertCell(4);
          cellButtons.innerHTML =
            `<button style="margin-left:10px; margin-right:10px" onclick="editarUsuario('${doc.id}')" class="btn btn-primary">Editar</button>` +
            `<button style="margin-left:10px; margin-right:10px" onclick="eliminarUsuario('${doc.id}')" class="btn btn-primary">Eliminar</button>`;

          var estado;
          if (data.status == 1) {
            estado = "Activo";
          } else {
            estado = "Inactivo";
          }

          const cellStatus = row.insertCell(4);
          cellStatus.textContent = estado;

          const cellPlan = row.insertCell(6);
          cellPlan.textContent = data.plan;
        }
      });
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al obtener documentos: ", error });
    });
}




function cargarDatosAdmin() {
  db.collection("login")
    .get()
    .then((querySnapshot) => {
      const tbody = document
        .getElementById("tabla")
        .getElementsByTagName("tbody")[0];

      while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
      }

      querySnapshot.forEach((doc) => {
        const data = doc.data();

        if (data.userType === "Admin") {
          const row = tbody.insertRow();

          const cellId = row.insertCell(0);
          cellId.textContent = data.nombregym;

          const cellUser = row.insertCell(1);
          cellUser.textContent = data.user;

          const cellPass = row.insertCell(2);
          cellPass.textContent = data.fechaAdd;

          const cellType = row.insertCell(3);
          cellType.textContent = data.userType;

          var estado;
          if (data.status == 1) {
            estado = "Activo";
          } else {
            estado = "Inactivo";
          }
          const cellStatus = row.insertCell(4);
          cellStatus.textContent = estado;

          const cellButtons = row.insertCell(5);
          cellButtons.innerHTML =
            `<button style="margin-left:10px; margin-right:10px" onclick="editarUsuario('${doc.id}')" class="btn btn-primary">Editar</button>` +
            `<button style="margin-left:10px; margin-right:10px" onclick="eliminarUsuario('${doc.id}')" class="btn btn-primary">Eliminar</button>`;

            const cellPlan = row.insertCell(6);
            cellPlan.textContent = data.plan;
        }
      });
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al obtener documentos: ", error });
    });
}

// Llama a la función al cargar la página
window.onload = cargarDatos;



// ================= FUNCION GUARDAR CAMBIOS USUARIO
function updateUser() {
  const updateId = document.getElementById("updateId").value;
  const updateName = document.getElementById("updateName").value;
  const updateUser = document.getElementById("updateUser").value;
  const updateStatus = document.getElementById("updateStatus").value;
  const updatePlanx = document.getElementById("updatePlan").value;


  const userRef = db.collection("login").doc(updateId);
    
  if (!updateName.trim() || !updateUser.trim()  || !updateStatus.trim()  || !updatePlanx.trim()) {
    Swal.fire({ icon: "warning", title: "Uno o más campos vacíos", text: "Porfavor, ingrese datos en los campos" });
    return;
}  
  userRef
    .update({
      nombregym: updateName,
      user: updateUser,
      status: updateStatus,
      plan: updatePlanx
    })
    .then(() => {
      Swal.fire({
        title: "Datos Actualizados.",
        text: "La contraseña será la misma, previa a los cambios realizados.",
        icon: "success",
      }).then(() => {
        setTimeout(() => {
          window.location.href = "https://biceps.cloudsoft.mx/superadmin/usersManager";
        }, 1000);
      });
    })
    .catch((error) => {
      Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar el documento: ", error });
    });
}





function cerrarModal() {
  document.getElementById("miModaledit").style.display = "none";
}



// =================  FUNCION OBTENER DATOS Y AÑADIR A INPUT
function editarUsuario(id) {
 
   var currentUserId4Upd = localStorage.getItem('idDoc'); 
   if (id === currentUserId4Upd) {
     Swal.fire({
       icon: "warning",
       title: "Operación no permitida",
       text: "Edite sus datos desde la opción Mi Perfil",
     });
     return;  
   }

  document.getElementById("miModaledit").style.display = "block";

  const docRef = db.collection('login').doc(id);
  docRef.get().then((doc) => {
    if (doc.exists) {
      const data = doc.data();
      const plan = data.plan;  

      document.getElementById("updateId").value = doc.id;
      document.getElementById("updateName").value = data.nombregym;
      document.getElementById("nameEdditingUser").textContent = data.nombregym;
      document.getElementById("updateUser").value = data.user;
      document.getElementById("updateStatus").value = data.status.toString();
      document.getElementById("updatePlan").value = data.plan.toString();

      // Mostrar u ocultar el input planGym basado en si el campo plan tiene datos
      const planGymInput = document.getElementById("updatePlan");
      const planGymLabel = document.getElementById("updatePlanLabel");
      if (plan) {
        planGymInput.style.display = "block";
        planGymLabel.style.display = "block";
      } else {
        planGymInput.style.display = "none";
        planGymLabel.style.display = "none";
      }

    } else {
      Swal.fire({ icon: "error", title: "Error", text: "No se encontró el documento!" });
    }
  }).catch((error) => {
    Swal.fire({ icon: "error", title: "Error", text: "Error al obtener el documento: " + error });
  });
}



// =================  FUNCION ELIMINAR USUARIO
function eliminarUsuario(id) {
  // Obtener el UID del usuario actualmente autenticado.
  var currentUserId = localStorage.getItem('idDoc');

  // Comparar el ID del usuario a eliminar con el UID del usuario autenticado.
  if (id === currentUserId) {
    Swal.fire({
      icon: "error",
      title: "Operación no permitida",
      text: "No puedes eliminar tu propia cuenta.",
    });
    return;  
  }

  // Si el ID no es el del usuario actual, proceder con la confirmación de eliminación.
  Swal.fire({
    title: "¿Estás seguro de que deseas eliminar este usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      const userRef = db.collection("login").doc(id);

      userRef
        .delete()
        .then(() => {
          Swal.fire({
            title: "Eliminado!",
            text: "El usuario ha sido eliminado.",
            icon: "success",
          });
          setTimeout(() => {
            window.location.href = "https://biceps.cloudsoft.mx/superadmin/usersManager";
          }, 1000);
        })
        .catch((error) => {
          Swal.fire({
            icon: "error",
            title: "Usuario no eliminado",
            text: "Ocurrió un error, por favor intenta de nuevo.",
          });
        });
    }
  });
}

