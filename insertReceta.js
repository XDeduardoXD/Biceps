function saveReceta() {
    const nameReceta = document.getElementById("nameReceta").value;
    const desReceta  = document.getElementById("desReceta").value; 
    const url = document.getElementById("imgReceta").value;  
  
    var user = localStorage.getItem('user');
    var docId = localStorage.getItem('idDoc');
    var namelogued = localStorage.getItem('usergym');
    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

    //Validamos Inputs Vacios
    if (!nameReceta.trim() || !desReceta.trim() || !url.trim()  ) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }

 
    if (validarInputsReceta(nameReceta, desReceta, url)) {
            // Datos que quieres añadir en el nuevo subdocumento
            var newSubDocumentData = {
                receta: nameReceta ,
                descripcion: desReceta,   
                url: url,
                dateAdd:formattedDate
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
                        userDocRef.collection("recetas_gym1").add(newSubDocumentData)
                            .then((docRef) => {
                                Swal.fire({ icon: "success", title: "Dato Insertado", text: "Se añadio la Receta de manera exitosa." }).then(() => {
                                    setTimeout(() => {  window.location.href = "https://biceps.cloudsoft.mx/admin/recetasManager"; }, 1000);
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
function validarInputsReceta(nameReceta, desReceta, url) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
    var regexInput3 = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    
    var esValidoInput1 = regexInput1.test(nameReceta);
    var esValidoInput2 = regexInput2.test(desReceta);
    var esValidoInput3 = regexInput3.test(url); 

    return esValidoInput1 && esValidoInput2 && esValidoInput3;
}
 