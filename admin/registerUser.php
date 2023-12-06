<!-- talvez borrar -->
<!DOCTYPE html>
<html lang="en">

<?php include 'getStorageScripts.php'; ?>
<?php include 'head.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">


        <?php include 'menu.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include 'barTop.php'; ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <center>
                        <h1 class="h3 mb-1">Agregar Usuario</h1>
                    </center>
                    <div>

                        <div>
                            <div class="card position-relative">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre:</label> <span class="help-form" id="helpNameUser">( Solo Letras, Números y Puntos. 3-50 caracteres )</span>
                                        <input type="text" class="form-control" id="nameUser" placeholder="Solo letras, Números y Puntos" /><br>
                                        <br>

                                        <label class="form-label">Usuario:</label> <span class="help-form" id="helpUserUser">(Formato correo electrónico, máximo 30 caracteres )</span>
                                        <input type="email" class="form-control" id="userUser" placeholder="example@example.com" /><br>
                                        <br>
                                        <!-- peso -->
                                        <label class="form-label">Peso:</label> <span class="help-form" id="helpUserPeso">(Formato numero, máximo 5 caracteres, valor máximo 250 )</span>
                                        <input type="text" class="form-control" id="pesoUser" placeholder="Ejemplo: 50.5 o 50" /><br>
                                        <br>
                                        <!-- altura -->
                                        <label class="form-label">Altura:</label> <span class="help-form" id="helpUserAltura">(Formato numero, máximo 4 caracteres , valor máximo 2.50)</span>
                                        <input type="text" class="form-control" id="alturaUser" placeholder="Ejemplo: 1.50" /><br>
                                        <br>

                                        <label class="form-label">Contraseña:</label> <span class="help-form" id="helpPassUser">( 6-16 caracteres, excepto: " <> {} ')</span>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="passUser" placeholder="Password" />
                                            <button id="togglePasswordAppuser" class="btn btn-primary" type="button"> Mostrar </button>
                                            <div id="passwordError" style="color:red;"></div>
                                        </div>

                                    </div>

                                    <input type="hidden" name="userTypeUser" id="userTypeUser" value="userNormal">


                                    <div class="mb-6">
                                        <label class="form-label">Status: </label> <span class="help-form" id="helpStatus"></span>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="statusUser" required>
                                            <option value="" selected> ¿Activo o Inactivo?</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="mb-6">
                                        <label class="form-label">Nivel : </label> <span class="help-form" id="helpnivel"></span>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="nivelUser" required>
                                            <option value="" selected> -- Elija nivel del usuario</option>
                                            <option value="principiante">Principiante</option>
                                            <option value="intermedio">Intermedio</option>
                                            <option value="experto">Experto</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="display: block;margin-left: auto;  margin-right: auto;" onclick="saveUser()">Guardar <i class="fas fa-check"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Logout Modal-->
    <?php include 'logoutModal.php'; ?>

    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore-compat.js"></script>
    <script src="../firebaseAccess.js"></script>
    <?php include 'scripts.php'; ?>
    <script src="../logOut.js"></script>
    <script src="../insertUser.js"></script>
    <script src="../updateProfileUser.js"></script>

    <script>
        document.getElementById('togglePasswordAppuser').addEventListener('click', function(e) {
            // Obtener el input de contraseña
            const passwordInput = document.getElementById('passUser');
            // Verificar si el tipo es password
            const isPassword = passwordInput.type === 'password';
            // Cambiar el tipo de input
            passwordInput.type = isPassword ? 'text' : 'password';
            // Cambiar el texto del botón
            this.textContent = isPassword ? 'Ocultar' : 'Mostrar';
        });

        ///VALIDAR INPUT NOMBRE
        document.getElementById('nameUser').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpNameUser');

            // Actualizada para incluir letras con acentos y otros caracteres especiales
            var regex = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,50}$/;
            var maxLengthPass = 50;

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
        document.getElementById('userUser').addEventListener('input', function() {
            var email = this.value;
            var helpText = document.getElementById('helpUserUser');
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
        document.getElementById('passUser').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpPassUser');
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


        //VALIDAR PESO 
        document.getElementById('pesoUser').addEventListener('input', function() {
            var peso = this.value;
            var helpText = document.getElementById('helpUserPeso');

            var regex = /^(3[5-9]|[4-9]\d|1\d{2}|2[0-4]\d|250)(\.\d{0,2})?$/;

            // Verificar si el valor cumple con la expresión regular
            if (regex.test(peso)) {
                helpText.style.color = 'green';
            } else {
                helpText.style.color = 'red';
            }

            // Verificar y eliminar el punto final si está presente y no seguido de dígitos
            if (peso.endsWith('.') && !/\.\d+$/.test(peso)) {
                setTimeout(() => {
                    if (this.value.endsWith('.')) {
                        this.value = this.value.slice(0, -1);
                    }
                }, 500); // Retraso para permitir la finalización de la entrada decimal
            }
        });





        //VALIDAR ALTURA 
        document.getElementById('alturaUser').addEventListener('input', function() {
            var altura = this.value;
            var helpText = document.getElementById('helpUserAltura');

            var regex = /^(1\.(?:[2-9]|[1-9][0-9])|2(?:\.(?:[0-4][0-9]?|5[0]?))?)$/;

            // Verificar si el valor cumple con la expresión regular
            if (regex.test(altura)) {
                helpText.style.color = 'green';
            } else {
                helpText.style.color = 'red';
            }


            if (altura.endsWith('.') && !/\.\d+$/.test(altura)) {
                setTimeout(() => {
                    if (this.value.endsWith('.')) {
                        this.value = this.value.slice(0, -1);
                    }
                }, 500); // Retraso para permitir la finalización de la entrada decimal
            }
        });
    </script>




</body>
<style>
    .help-form {
        margin-left: 42px;
        font-size: 14px;
        font-weight: 600;
    }
</style>

</html>