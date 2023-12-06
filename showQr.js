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

function onloadAdvices(
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
        .collection("tutoriales")
        .get()
        .then((snapshot) => {
            if (!snapshot.empty) {
                snapshot.forEach((doc) => {
                    const data = doc.data();
                    const tbody = document
                        .getElementById("tabla")
                        .getElementsByTagName("tbody")[0];
                    const row = tbody.insertRow();
                    
                    const cellid = row.insertCell(0);
                    cellid.textContent = data.id;

                    // Celda para nombre
                    const cellNombre = row.insertCell(1);
                    cellNombre.textContent = data.titulo;

                    // Celda para descripcion
                    const cellDescripcion = row.insertCell(2);
                    cellDescripcion.textContent = data.descripcion || "";

                    const cellUrl = row.insertCell(3); // Suponiendo que 'row' ya está definido y es la fila actual de la tabla
                    // Asumiendo que 'data.url' contiene la URL de la imagen
                    if (data.url) {
                        // Crear un elemento img
                        const img = document.createElement('img');
                        
                        // Extraer el ID del video de YouTube de la URL proporcionada en data.imagen
                        const youtubeIdMatch = data.url.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
                        const youtubeId = youtubeIdMatch ? youtubeIdMatch[1] : null;
                        
                        if (youtubeId) {
                            // Si se encontró un ID de video, configura la URL de la miniatura de YouTube
                            img.src = `https://img.youtube.com/vi/${youtubeId}/0.jpg`;
                        } else {
                            // Si no se encontró un ID de video, podría ser una URL de imagen regular
                            img.src = data.url;
                        }
                        
                        // Establecer el estilo de la imagen
                        img.style.width = '100px'; // Ajusta el ancho de la imagen
                        img.style.height = 'auto'; // Ajusta la altura automáticamente para mantener la proporción
                        cellUrl.appendChild(img); // Añade la imagen a la celda
                    } else {
                        cellUrl.textContent = "No hay imagen"; // Texto alternativo si no hay URL
                    }
                    

       
                    // Celdas para botones
                    const cellButtons = row.insertCell(4);
                    cellButtons.innerHTML =
                        `<div style="display: flex; justify-content: space-between;">` +
                        `<button style="margin-left:10px; margin-right:10px;" onclick="deleteQr('${doc.id}')" class="btn btn-primary">Eliminar</button>` +
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

window.onload = onloadAdvices;

 


// =================  FUNCION OBTENER DATOS Y AÑADIR A INPUT
function editQr(subDocumentId) {
    document.getElementById("miModaleditQr").style.display = "block";
    const docId = localStorage.getItem("idDoc");

    const docRef = db
        .collection("login")
        .doc(docId)
        .collection("nutricion")
        .doc(subDocumentId);
    docRef
        .get()
        .then((doc) => {
            if (doc.exists) {
                const data = doc.data();  
                document.getElementById("updateIdAdvice").value = doc.id;
                document.getElementById("adviceUpd").value = data.titulo;
                document.getElementById("desAdviceUpd").value = data.descripcion; 
                document.getElementById("urlAdviceUpd").value = data.imagen; 
                document.getElementById("nameEdditingAdvice").textContent = data.titulo;
                document.getElementById("dayAdviceUpd").value = data.dia.toString();

            } else {
                Swal.fire({ icon: "error", title: "Error", text: "No se encontró el documento!" });
            }
        })
        .catch((error) => { 
            Swal.fire({ icon: "error", title: "Error", text: "Error al obtener el documento:", error });
        });
}




// ================= FUNCION GUARDAR CAMBIOS USUARIO
function updateQr() {
    const updateId = document.getElementById("updateIdAdvice").value;
    const adviceUpd = document.getElementById("adviceUpd").value;
    const desAdviceUpd = document.getElementById("desAdviceUpd").value; 
    const urlAdviceUpd = document.getElementById("urlAdviceUpd").value; 
    const docId = localStorage.getItem("idDoc");

    const day = document.getElementById("dayAdviceUpd").value;  
    const dayNumer = Number(day);

    
    if (!adviceUpd.trim() || !desAdviceUpd.trim()  || !urlAdviceUpd.trim()  || !day.trim()) {
        Swal.fire({ icon: "info", title: "Uno o más campos vacíos", text: "Porfavor, ingrese datos en los campos" });
        return;
    }  
    const userRef = db
        .collection("login")
        .doc(docId)
        .collection("tutoriales")
        .doc(updateId); 


    if (validarInputsAdvice(adviceUpd, desAdviceUpd, urlAdviceUpd)) {
        userRef
            .update({ titulo: adviceUpd, descripcion: desAdviceUpd, imagen: urlAdviceUpd, dia: dayNumer})
            .then(() => {
                Swal.fire({
                    title: "Datos Actualizados.", text: "EL Qr se mostrará con la nueva Información", icon: "success"
                }).then(() => {
                    setTimeout(() => { window.location.href = "https://biceps.cloudsoft.mx/admin/qrManager"; }, 1000);
                });
            })
            .catch((error) => {
                Swal.fire({ icon: "error", title: "Error", text: "Error al actualizar el documento: ", error });
            });
    } else { 
        Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
    }
}




// =========================Función para ELIMINAR un documento de una subcolección
function deleteQr(subDocumentId) {
    Swal.fire({
        title: "¿Estás seguro de que deseas eliminar este Qr?", text: "No podrás revertir esta acción!",  icon: "warning",  showCancelButton: true, confirmButtonColor: "#3085d6",  cancelButtonColor: "#d33", confirmButtonText: "Si, eliminarlo!",
    }).then((result) => {
        if (result.isConfirmed) {
            const docId = localStorage.getItem("idDoc");
            if (!docId) {
                Swal.fire({ icon: "error", title: "Error", text: "Registro no encontrado" });
                return;
            }
            const subDocRef = db
                .collection("login")
                .doc(docId)
                .collection("tutoriales")
                .doc(subDocumentId);

            subDocRef
                .delete()
                .then(() => {
                    Swal.fire("Eliminado!", "El Qr ha sido eliminado.", "success");
                    setTimeout(() => {  window.location.href =    "https://biceps.cloudsoft.mx/admin/qrManager";   }, 1000);
                })
                .catch((error) => {
                    Swal.fire({  icon: "error",  title: "Error",  text: "Hubo un problema al eliminar el documento: " + error, });
                });
        }
    });
}

////FUNCION CLOSE MODAL TIP

function cerrarModalAdvice() {
    document.getElementById("miModaleditAdvice").style.display = "none";
}






// Función VALIDACION INPUTS
function validarInputsAdvice(adviceUpd, desAdviceUpd, urlAdviceUpd) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
    var regexInput3 = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
   


    var esValidoInput1 = regexInput1.test(adviceUpd);
    var esValidoInput2 = regexInput2.test(desAdviceUpd);
    var esValidoInput3 = regexInput3.test(urlAdviceUpd); 

    return esValidoInput1 && esValidoInput2 && esValidoInput3;
}