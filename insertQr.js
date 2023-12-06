let currentId = parseInt(localStorage.getItem('currentId')) || 0;

function saveQr() {
    const nameQr = document.getElementById("nameQr").value;
    const desQr  = document.getElementById("desQr").value; 
    const imgQr = document.getElementById("imgQr").value; 
    currentId = (parseInt(currentId) + 1).toString();

    localStorage.setItem('currentId', currentId);
 
    var user = localStorage.getItem('user');
    var docId = localStorage.getItem('idDoc');
    var namelogued = localStorage.getItem('usergym');
    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

    //Validamos Inputs Vacios
    if (!nameQr.trim() || !desQr.trim() || !imgQr.trim()  ) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }

 
    if (validarInputsAdvice(nameQr, desQr, imgQr)) {
            // Datos que quieres añadir en el nuevo subdocumento
            var newSubDocumentData = {
                id: currentId,
                titulo: nameQr,
                descripcion: desQr,   
                url: imgQr,
            };

            // Referencia a la colección 'login'
            var loginRef = db.collection('login');

            // Buscar documento con user igual a usuarioInput
            loginRef.where("user", "==", user).get()
                .then((querySnapshot) => {
                    if (!querySnapshot.empty) {
                        // Si existe, obtener el primer documento que coincida
                        var userDocRef = querySnapshot.docs[0].ref; // Referencia al documento

                        // Crear una nueva subcolección (si no existe) y añadir el documento
                        userDocRef.collection("tutoriales").add(newSubDocumentData)
                            .then((docRef) => {
                                Swal.fire({ icon: "success", title: "Dato Insertado", text: "Se añadio el Consejo del Día de manera exitosa." }).then(() => {
                                    setTimeout(() => {  window.location.href = "https://biceps.cloudsoft.mx/admin/qrManager"; }, 1000);
                                  });   
                                })
                            .catch((error) => {
                                Swal.fire({ icon: "error", title: "Error", text: "Intente nuevamente", error }); 
                            });
                    } else { 
                        Swal.fire({ icon: "error", title: "Ocurrio un Error", text: "No se encontró un documento con el usuario" });
                    }
                })
                .catch((error) => {
                    Swal.fire({ icon: "error", title: "Ocurrio un Error", text: "Intente Nuevamente." }); 
                });
    }else{
        Swal.fire({ icon: "error", title: "Formato no Admitido", text: "Inserte datos como se le sugieren" });
    }
}



 
// Función VALIDACION INPUTS
function validarInputsAdvice(nameQr, desQr, imgQr) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
    var regexInput3 = /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9\-_]+$/;
    



    var esValidoInput1 = regexInput1.test(nameQr);
    var esValidoInput2 = regexInput2.test(desQr);
    var esValidoInput3 = regexInput3.test(imgQr); 

    return esValidoInput1 && esValidoInput2 && esValidoInput3;
}
 