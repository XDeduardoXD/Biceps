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
                        <h1 class="h3 mb-1">Agregar Consejos del Día</h1>
                    </center>
                    <div>

                        <div>
                            <div class="card position-relative">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label class="form-label">Título:</label> <span class="help-form" id="helpNameAdvice">Solo Letras, Números y Puntos. 3-50 caracteres</span>
                                        <input type="text" class="form-control" id="nameAdvice" placeholder="Solo letras, Números y Puntos" /><br>
                                        <br>

                                        <label class="form-label">Descripcion del Consejo:</label> <span class="help-form" id="helpDesAdvice">Solo Letras, Números y Puntos. 3-200 caracteres</span>
                                         <textarea class="form-control" id="desAdvice" placeholder="Solo letras, Números y Puntos" rows="3"></textarea>
                                        <br>

                                        <label class="form-label">Imagen ilustrativa:</label> <span class="help-form" id="helpImgAdvice">Solo formatos URl</span>
                                        <input type="url" class="form-control" id="imgAdvice" placeholder="https://img/118dd170cec0f.gif" /><br>
                                        <br>  
                                    </div>

                                    <div class="mb-6">
                                        <label class="form-label">Dia que se mostrará: </label> <span class="help-form" id="helpDayAdvice"></span>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="dayAdvice" required>
                                            <option value="" selected> -- Elija  día--</option>
                                            <option value="1">Lunes</option>
                                            <option value="2">Martes</option>
                                            <option value="3">Miercoles</option>
                                            <option value="4">Jueves</option>
                                            <option value="5">Viernes</option>
                                            <option value="6">Sabado</option>
                                            <option value="7">Domingo</option> 
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="display: block;margin-left: auto;  margin-right: auto;" onclick="saveAdvice()">Guardar <i class="fas fa-check"></i></button>
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
    <script src="../insertAdvice.js"></script>
    <script src="../updateProfileUser.js"></script>

    <script>
        ///VALIDAR INPUT NOMBRE
        document.getElementById('nameAdvice').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpNameAdvice');
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
        ///VALIDAR INPUT DESCRIPCION
        document.getElementById('desAdvice').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpDesAdvice');
            var regex = /^[a-zA-Z0-9. áéíóúÁÉÍÓÚñÑüÜ]{3,200}$/;
            var maxLengthPass = 200;

            if (password.length > maxLengthPass) {
                this.value = password.substr(0, maxLengthPass);
            }

            if (regex.test(password)) {
                helpText.style.color = 'green';
            } else {
                helpText.style.color = 'red';
            }
        });

        ///VALIDAR INPUT URL
        document.getElementById('imgAdvice').addEventListener('input', function() {
            var url = this.value;
            var helpText = document.getElementById('helpImgAdvice');
            // Expresión regular para validar URLs
            var regex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            var maxLengthUrl = 200;

            if (url.length > maxLengthUrl) {
                this.value = url.substr(0, maxLengthUrl);
            }
            if (regex.test(url)) {
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