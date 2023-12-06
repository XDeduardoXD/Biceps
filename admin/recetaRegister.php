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
                        <h1 class="h3 mb-1">Agregar Receta Saludable</h1>
                    </center>
                    <div>

                        <div>
                            <div class="card position-relative">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre Receta:</label> <span class="help-form" id="helpNameReceta">Solo Letras, Números y Puntos. 3-50 caracteres</span>
                                        <input type="text" class="form-control" id="nameReceta" placeholder="Solo letras, Números y Puntos" /><br>
                                        <br>

                                        <label class="form-label">Descripcion de la Receta:</label> <span class="help-form" id="helpDesReceta">Solo Letras, Números y Puntos. 3-200 caracteres</span>
                                         <textarea class="form-control" id="desReceta" placeholder="Solo letras, Números y Puntos" rows="3"></textarea>
                                        <br>

                                        <label class="form-label">Imagen ilustrativa:</label> <span class="help-form" id="helpImgReceta">Solo formatos URl</span>
                                        <input type="email" class="form-control" id="imgReceta" placeholder="https://img/118dd170cec0f.gif" /><br>
                                        <br>  
                                    </div>
  
                                    <button type="submit" class="btn btn-primary" style="display: block;margin-left: auto;  margin-right: auto;" onclick="saveReceta()">Guardar <i class="fas fa-check"></i></button>
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
    <script src="../insertReceta.js"></script>
    <script src="../updateProfileUser.js"></script>

    <script>
        ///VALIDAR INPUT NOMBRE
        document.getElementById('nameReceta').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpNameReceta');
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
        document.getElementById('desReceta').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpDesReceta');
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
        document.getElementById('imgReceta').addEventListener('input', function() {
            var url = this.value;
            var helpText = document.getElementById('helpImgReceta');
            // Expresión regular para validar URLs
            var regex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            var maxLengthUrl = 100;

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