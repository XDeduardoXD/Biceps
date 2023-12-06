function saveTip() {
    const nameTip = document.getElementById("nameTip").value;
    const desTip = document.getElementById("descripTip").value; 
    const url = document.getElementById("imgTip").value; 
    const minImc = document.getElementById("MinImc").value;
    const maxImc = document.getElementById("MaxImc").value;
 
    let minImcNumber = Number(minImc);
    let maxImcNumber = Number(maxImc);
    var user = localStorage.getItem('user');
    var docId = localStorage.getItem('idDoc');
    var namelogued = localStorage.getItem('usergym');
    const now = new Date();
    const formattedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

    //Validamos Inputs Vacios
    if (!nameTip.trim() || !desTip.trim() || !url.trim() || !minImc.trim() || !maxImc.trim() ) {
        Swal.fire({ icon: "error", title: "Uno o más campos Vacios.", text: "Debe Llenar todos los campos" });
        return;
    }

 
    if (validarInputsx(nameTip, desTip, url, minImc,maxImc)) {
            // Datos que quieres añadir en el nuevo subdocumento
            var newSubDocumentData = {
                tip: nameTip,
                descripcion: desTip,   
                url: url,
                minImc: minImcNumber,
                maxImc: maxImcNumber,
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
                        userDocRef.collection("tips_gym1").add(newSubDocumentData)
                            .then((docRef) => {
                                Swal.fire({ icon: "success", title: "Dato Insertado", text: "Se añadio el Tip de manera exitosa." }).then(() => {
                                    setTimeout(() => {  window.location.href = "https://biceps.cloudsoft.mx/admin/tipsManager"; }, 1000);
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
function validarInputsx(nameTip, desTip, url, minImc,maxImc) {
    var regexInput1 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
    var regexInput2 = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
    var regexInput3 = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    var regexInput4 =  /^\d{1,2}$/;
    var regexInput5 =  /^\d{1,2}$/;



    var esValidoInput1 = regexInput1.test(nameTip);
    var esValidoInput2 = regexInput2.test(desTip);
    var esValidoInput3 = regexInput3.test(url);
    var esValidoInput4 = regexInput4.test(minImc);
    var esValidoInput5 = regexInput5.test(maxImc);

    return esValidoInput1 && esValidoInput2 && esValidoInput3 && esValidoInput4 && esValidoInput5;
}
 