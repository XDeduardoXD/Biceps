<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">  <div id="roleDisplay"></div>  -   <div id="nameLogued"></div>

    <!-- Boton ir al Top -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"> <i class="fa fa-bars"></i>
    </button>



    <!-- BARRA TOP  -->
    <ul class="navbar-nav ml-auto">  

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">  
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-800">
                <div id="userDisplay"></div>
                </span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#miModal">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perfil
                </a>


                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar Sesión
                </a>
            </div>
        </li>

    </ul>

</nav>
  
<div id="miModal" class="modalx">
 
    <div class="modal-contentx">
        <a href="#" class="close-button">×</a>
       <center> <h2>Editar Mis Datos</h2></center>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Nombre:</label> <span class="help-form" id="helpNameProfile">( Solo Letras, Números y Puntos. 3-20 caracteres )</span>
                <input type="hidden" id="myId"/><br>
                <input type="text" class="form-control" id="myName" placeholder="Nombre..." /><br>

                <label class="form-label">Usuario:</label><span class="help-form" id="helpUserProfile"></span>
                <input type="email" class="form-control" id="myUser" placeholder="Correo electrónico..." disabled /><br>

               
 
                <label class="form-label">Contraseña:</label> (Solo si desea actualizarla) <span class="help-form" id="helpPassProfile"> ( 6-16 caracteres, excepto: " <> {} ')</span>
                <div class="input-group"> 
                    <input type="password" class="form-control" id="myPass" placeholder="Password" />
                    <button id="togglePassword" class="btn btn-primary" type="button"> Mostrar </button>
                 <div id="passwordError" style="color:red;"></div>
                 </div>
            </div>
 
            <button type="submit" class="btn btn-primary"  style="display: block;margin-left: auto;  margin-right: auto;" onclick="updateProfile()">Guardar cambios <i class="fas fa-check"></i></button>
        </div>
    </div>
</div>   
 

<script>
            //==============================VALIDACIONES INPUT   ============================//

            //Mostrar Ocultar Password
            document.getElementById('togglePassword').addEventListener('click', function(e) {
                const passwordInput = document.getElementById('myPass');
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                this.textContent = isPassword ? 'Ocultar' : 'Mostrar';
            });

            ///VALIDAR INPUT NOMBRE
            document.getElementById('myName').addEventListener('input', function() {
                var password = this.value;
                var helpText = document.getElementById('helpNameProfile');
                var regex = /^[a-zA-Z0-9. ]{3,30}$/;
                var maxLengthPass = 31;

                if (password.length > maxLengthPass) {
                    this.value = password.substr(0, maxLengthPass);
                }

                if (regex.test(password)) {
                    helpText.style.color = 'green';
                } else {
                    helpText.style.color = 'red';
                }
            });




            // VALIDAR INPUT CORREO ELECTRÓNICO
            document.getElementById('myUser').addEventListener('input', function() {
                var email = this.value;
                var helpText = document.getElementById('helpUserProfile');
                var regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
                var maxLengthUser = 30;

                if (email.length > maxLengthUser) {
                    this.value = email.substr(0, maxLengthUser);
                }

                if (email.length <= 30 && regexEmail.test(email)) {
                    helpText.style.color = 'green';
                } else {
                    helpText.style.color = 'red';
                }
            });


            // VALIDAR INPUT CONTRASEÑA
            document.getElementById('myPass').addEventListener('input', function() {
                var password = this.value;
                var helpText = document.getElementById('helpPassProfile');
                var regex = /^[^' "<>{}]{6,17}$/;
                var maxLengthPass = 16;

                if (password.length > maxLengthPass) {
                    this.value = password.substr(0, maxLengthPass);
                }

                if (regex.test(password)) {
                    helpText.style.color = 'green';
                } else {
                    helpText.style.color = 'red';
                }
            });
        </script>
<style>   
    .modalx {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0, 0, 0); 
        background-color: rgba(0, 0, 0, 0.7); 
    }

    /* Estilo del Contenido de la Modal */
    .modal-contentx {
        background-color: #fefefe;
        margin: 15% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 60%; 
    }

    /* El Botón de Cerrar (x) */
    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-button:hover,
    .close-button:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Muestra la modal cuando #miModal está en la URL */
    #miModal:target {
        display: block;
    }

    .help-form {
        margin-left: 42px;
        font-size: 14px;
        font-weight: 600;
    }
</style>  