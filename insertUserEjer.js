function saveUserEjer() {
    const categoria = document.getElementById("categoriaEjer").value;
    const descripcion = document.getElementById("descripEJer").value;
    const dia = document.getElementById("diaEJer").value;
    const nivel = document.getElementById("nivelEjer").value;
    const nombre = document.getElementById("nameEJer").value;
    const repeticiones = document.getElementById("repitiEjer").value;
    const url = document.getElementById("imgEjer").value;


    let diaNumber = Number(dia);
    let repeticionesNumber = Number(repeticiones);
    var user = localStorage.getItem('user');
    var docId = localStorage.getItem('idDoc');
    var namelogued = localStorage.getItem('usergym');
    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

    //Validamos Inputs Vacios
    if (!categoria.trim() || !descripcion.trim() || !dia.trim() || !nivel.trim() || !nombre.trim() || !repeticiones.trim() || !url.trim()) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }

 
    if (validarInputsx(nombre, descripcion, url, repeticiones)) {
            // Datos que quieres añadir en el nuevo subdocumento
            var newSubDocumentData = {
                categoria: categoria,
                descripcion: descripcion,
                dia: diaNumber,
                nivel: nivel,
                nombre: nombre,
                repeticiones: repeticionesNumber,
                url: url,
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

                        // Crear una nueva subcolección (si no existe) y añadir el documento
                        userDocRef.collection("ejer_gym1").add(newSubDocumentData)
                            .then((docRef) => {
                                Swal.fire({ icon: "success", title: "Dato Insertado", text: "Se añadio el usuario de manera exitosa." }).then(() => {
                                    setTimeout(() => {  window.location.href = "https://biceps.cloudsoft.mx/admin/usersAppManagerEjer"; }, 1000);
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
function validarInputsx(nombre, descripcion, url, repeticiones) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
    var regexInput3 = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    var regexInput4 = /^\d{1,3}$/;


    var esValidoInput1 = regexInput1.test(nombre);
    var esValidoInput2 = regexInput2.test(descripcion);
    var esValidoInput3 = regexInput3.test(url);
    var esValidoInput4 = regexInput4.test(repeticiones);

    return esValidoInput1 && esValidoInput2 && esValidoInput3 && esValidoInput4;
}
 