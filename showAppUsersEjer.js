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
        .collection("ejer_gym1")
        .get()
        .then((snapshot) => {
            if (!snapshot.empty) {
                snapshot.forEach((doc) => {
                    const data = doc.data();
                    const tbody = document
                        .getElementById("tabla")
                        .getElementsByTagName("tbody")[0];
                    const row = tbody.insertRow();

                    // Celda para nombre
                    const cellNombre = row.insertCell(0);
                    cellNombre.textContent = data.nombre;

                    // Celda para descripcion
                    const cellDescripcion = row.insertCell(1);
                    cellDescripcion.textContent = data.descripcion || "";

                    // Celda para fechaAdd
                    const cellFecha = row.insertCell(2);
                    cellFecha.textContent = data.fechaAdd || "";


                    const cellUrl = row.insertCell(3); // Suponiendo que 'row' ya está definido y es la fila actual de la tabla
                    // Asumiendo que 'data.url' contiene la URL de la imagen
                    if (data.url) {
                        const img = document.createElement('img');
                        img.src = data.url; // Establece la URL de la imagen
                        img.style.width = '100px'; // Ajusta el ancho de la imagen
                        img.style.height = 'auto'; // Ajusta la altura automáticamente para mantener la proporción
                        cellUrl.appendChild(img); // Añade la imagen a la celda
                    } else {
                        cellUrl.textContent = "No hay imagen"; // O cualquier texto que desees mostrar si no hay URL
                    }

                    const cellRepeticiones = row.insertCell(4);
                    cellRepeticiones.textContent = data.repeticiones || "";


                    var Categoria;
                    if (data.categoria === "abdomen") {
                        Categoria = "abdomen";

                    } else if (data.categoria === "brazo") {
                        Categoria = "brazo";

                    } else if (data.categoria === "pierna") {
                        Categoria = "pierna";

                    } else if (data.categoria === "gluteo") {
                        Categoria = "gluteo";

                    } else if (data.categoria === "pierde peso") {
                        Categoria = "pierde peso";

                    } else if (data.categoria === "define musculos") {
                        Categoria = "define musculos";

                    } else {
                        Categoria = "--"; // En caso de que data.nivel no sea ninguno de los anteriores
                    }
                    const cellCategoria = row.insertCell(5);
                    cellCategoria.textContent = Categoria;


                    var Dia;
                    if (data.dia === 1) {
                        Dia = "Lunes";

                    } else if (data.dia === 2) {
                        Dia = "Martes";

                    } else if (data.dia === 3) {
                        Dia = "Miercoles";

                    } else if (data.dia === 4) {
                        Dia = "Jueves";

                    } else if (data.dia === 5) {
                        Dia = "Viernes";

                    } else if (data.dia === 6) {
                        Dia = "Sabado";

                    } else if (data.dia === 7) {
                        Dia = "Domingo";

                    } else {
                        Dia = "--"; // En caso de que data.nivel no sea ninguno de los anteriores
                    }
                    const cellDia = row.insertCell(6);
                    cellDia.textContent = Dia;

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
function updateUserEjer() {

    const updateId = document.getElementById("updateId").value;
    const categoriaUpdate = document.getElementById("categoriaUpdate").value;
    const descripcionUpdate = document.getElementById("descripcionUpdate").value;
    const diaUpdate = document.getElementById("diaUpdate").value;
    const nivelUpdate = document.getElementById("nivelUpdate").value;
    const nombreUpdate = document.getElementById("nombreUpdate").value;
    const repeticionesUpdate = document.getElementById("repeticionesUpdate").value;
    const urlUpdate = document.getElementById("urlUpdate").value;
    const docId = localStorage.getItem("idDoc");
    const userRef = db
        .collection("login")
        .doc(docId)
        .collection("ejer_gym1")
        .doc(updateId);

    let diaNumberUpdate = Number(diaUpdate);
    let repeticionesNumberUpdate = Number(repeticionesUpdate);

    if (!descripcionUpdate.trim() && !nombreUpdate.trim() && !repeticionesUpdate.trim() && !urlUpdate.trim()) {
        Swal.fire({ icon: "info", title: "Uno o más campos vacíos", text: "Porfavor, ingrese datos en los campos" });
        return;
    } else if (!descripcionUpdate.trim() || !nombreUpdate.trim() || !repeticionesUpdate.trim() || !urlUpdate.trim()) {
        Swal.fire({ icon: "info", title: "Nombre o Usuario vacío", text: "Porfavor, ingrese datos en los campos" });
        return;
    }

    if (validarInputsEjer(nombreUpdate, descripcionUpdate, urlUpdate, repeticionesUpdate)) {
        userRef
            .update({ categoria: categoriaUpdate, descripcion: descripcionUpdate, dia: diaNumberUpdate, nivel: nivelUpdate, nombre: nombreUpdate, repeticiones: repeticionesNumberUpdate, url: urlUpdate })
            .then(() => {
                Swal.fire({
                    title: "Datos Actualizados.", text: "La contraseña será la misma, previa a los cambios realizados.", icon: "success"
                }).then(() => {
                    setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/admin/usersAppManagerEjer"; }, 1000);
                });
            })
            .catch((error) => {
                Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar el documento: ", error });
            });
    } else {
        console.log("xd");
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
        .collection("ejer_gym1")
        .doc(subDocumentId);
    docRef
        .get()
        .then((doc) => {
            if (doc.exists) {
                const data = doc.data();
                document.getElementById("updateId").value = doc.id;
                document.getElementById("categoriaUpdate").value = data.categoria.toString();
                document.getElementById("descripcionUpdate").value = data.descripcion;
                document.getElementById("diaUpdate").value = data.dia.toString();
                document.getElementById("nivelUpdate").value = data.nivel.toString();
                document.getElementById("nombreUpdate").value = data.nombre;
                document.getElementById("repeticionesUpdate").value = data.repeticiones;
                document.getElementById("urlUpdate").value = data.url;

                document.getElementById("nameEdditing").textContent = data.nombre;
            } else {
                Swal.fire({ icon: "error", title: "Error", text: "No se encontró el documento!" });
            }
        })
        .catch((error) => {
            console.log("xdd",error)
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
                .collection("ejer_gym1")
                .doc(subDocumentId);

            subDocRef
                .delete()
                .then(() => {
                    Swal.fire("Eliminado!", "El documento ha sido eliminado.", "success");
                    setTimeout(() => {
                        window.location.href =
                            "https://biceps.cloudsoft.mx/admin/usersAppManagerEjer";
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
function validarInputsEjer(nombreUpdate, descripcionUpdate, urlUpdate, repeticionesUpdate) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
    var regexInput3 = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    var regexInput4 = /^\d{1,3}$/;


    var esValidoInput1 = regexInput1.test(nombreUpdate);
    var esValidoInput2 = regexInput2.test(descripcionUpdate);
    var esValidoInput3 = regexInput3.test(urlUpdate);
    var esValidoInput4 = regexInput4.test(repeticionesUpdate);

    return esValidoInput1 && esValidoInput2 && esValidoInput3 && esValidoInput4;
}
