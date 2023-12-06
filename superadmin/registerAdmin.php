<!-- talvez borrar -->
<!DOCTYPE html>
<html lang="en">
<!-- // OBTENER VARIABLE DE SESSION , EN SU DEFECTO, MANDAR A LOGIN -->
<?php include 'getStorageScripts.php'; ?> 

<?php include 'head.php'; ?>

<body id="page-top"> 
    <div id="wrapper">
        <?php include 'menu.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <?php include 'barTop.php'; ?>

                <div class="container-fluid">
                    <center>
                        <h1 class="h3 mb-1">Agregar Nuevo Administrador</h1>
                    </center>

                    <div class="card position-relative">
                        <div class="card-body">

                        <div class="mb-3">
                                <label class="form-label">Nombre del Administrador:</label> <span class="help-form" id="helpNameAdmin">( Solo Letras, Números y Puntos. 3-50 caracteres )</span>
                                <input type="text" class="form-control" id="nameAdmin" placeholder="Solo letras, Números y Puntos" /><br>
                                <br>

                                <label class="form-label">Usuario Administrador:</label> <span class="help-form" id="helpUserAdmin">(Formato correo electrónico, máximo 30 caracteres )</span>
                                <input type="email" class="form-control" id="userAdmin" placeholder="example@example.com" /><br>
                                <br>

                                <label class="form-label">Contraseña:</label> <span class="help-form" id="helpPassAdmin">( 6-16 caracteres, excepto: " <> {} ')</span>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="passAdmin" placeholder="Password" />
                                    <button id="togglePasswordAdmin" class="btn btn-primary" type="button"> Mostrar </button>
                                    <div id="passwordError" style="color:red;"></div>
                                </div>

                                <input type="hidden" id="userTypeAdmin" value="superAdmin">

                                <br><br>
                                <div class="mb-6">
                                    <label class="form-label">Status: </label> <span class="help-form" id="helpStatus"></span>
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="statusAdmin" required>
                                        <option value="" selected> ¿Activo o Inactivo?</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>

                                <input class="btn btn-primary" type="submit" style="display: block;  margin-left: auto; margin-right: auto;" onclick="saveAdmin()" value="Guardar">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- End of Page Wrapper -->

    <a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i> </a>


    <!-- Logout Modal-->
    <?php include 'logoutModal.php'; ?>

    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore-compat.js"></script>
    <script src="../firebaseAccess.js"></script>
    <?php include 'scripts.php'; ?>
    <script src="../logOut.js"></script>
    <script src="../insertAdmin.js"></script>
    <script src="../updateProfile.js"></script>
    <script>
            //==============================VALIDACIONES INPUT   ============================//

            //Mostrar Ocultar Password
            document.getElementById('togglePasswordAdmin').addEventListener('click', function(e) {
                const passwordInput = document.getElementById('passAdmin');
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                this.textContent = isPassword ? 'Ocultar' : 'Mostrar';
            });

            ///VALIDAR INPUT NOMBRE
            document.getElementById('nameAdmin').addEventListener('input', function() {
                var password = this.value;
                var helpText = document.getElementById('helpNameAdmin');
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
            document.getElementById('userAdmin').addEventListener('input', function() {
                var email = this.value;
                var helpText = document.getElementById('helpUserAdmin');
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
            document.getElementById('passAdmin').addEventListener('input', function() {
                var password = this.value;
                var helpText = document.getElementById('helpPassAdmin');
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


</body>
<style>
    .help-form {
        margin-left: 42px;
        font-size: 14px;
        font-weight: 600;
    }
</style>

</html>