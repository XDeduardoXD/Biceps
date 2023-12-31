<script>
    if (!localStorage.getItem('usuario_logeado')) {
        window.location.href = "../index";
    } else {
        document.addEventListener("DOMContentLoaded", function () {
            var user = localStorage.getItem('user');
            document.getElementById('userDisplay').textContent = user;

            var role = localStorage.getItem('userType'); 
            document.getElementById('roleDisplay').textContent = role;

            var namelogued = localStorage.getItem('usergym');
            document.getElementById('nameLogued').textContent = namelogued;

            var nameInput = document.getElementById('myName');
            nameInput.value = namelogued;

            var mailInput = document.getElementById('myUser');
            mailInput.value = user;

            var gottenMiId = localStorage.getItem('idDoc');
            var miId = document.getElementById('myId');
            miId.value = gottenMiId;  
        });
    }





     // ==========================    MANEJO DE SESIONES   

            function verificarRolRequerido(rolRequerido) {
                const userType = localStorage.getItem('userType');

                if (userType !== rolRequerido) {  
                    Swal.fire({
                        title: "Admin. Acceso Denegado", text: "Será redirigido a su directorio correspondiente", icon: "error",allowOutsideClick: false   }).then(() => {
                        setTimeout(() => {  window.location.href = "https://biceps.cloudsoft.mx/admin/index"; }, 200);
                        });  
                }
            }

        document.addEventListener('DOMContentLoaded', (event) => {
            verificarRolRequerido('superAdmin');
        });



                    // Deshabilitar F12
            document.addEventListener("keydown", function(event){
                if(event.keyCode == 123) { // 123 es el código de tecla para F12
                    event.preventDefault();
                    
                }
            });

            // Deshabilitar clic derecho
            document.addEventListener("contextmenu", function(event){
                event.preventDefault();
                
            });

      
</script>

 