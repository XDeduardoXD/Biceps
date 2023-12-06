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
                        <h1 class="h3 mb-1">Agregar Ejercicios</h1>
                    </center>
                    <div>

                        <div>
                            <div class="card position-relative">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre del Ejercicio:</label> <span class="help-form" id="helpNameEjer">( Solo Letras, Números y Puntos. 3-50 caracteres )</span>
                                        <input type="text" class="form-control" id="nameEJer" placeholder="Solo letras, Números y Puntos" /><br>
                                        <br>

                                        <label class="form-label">Descripcion del ejercicio:</label> <span class="help-form" id="helpDescripEjer">( Solo Letras, Números y Puntos. 3-200 caracteres )</span>
                                        <textarea type="text" class="form-control" id="descripEJer" placeholder="Solo letras, Números y Puntos" /></textarea>
                                        <br>

                                        <label class="form-label">Imagen a mostrar:</label> <span class="help-form" id="helpImgEjer">(Solo formatos URl)</span>
                                        <input type="email" class="form-control" id="imgEjer" placeholder="https://img/118dd170cec0f.gif" /><br>
                                        <br>

                                        <label class="form-label">Numero de repiticiones:</label> <span class="help-form" id="helpRepitiEjer">(Formato numero, máximo 3 caracteres, Valor minimo 5, valor máximo 100 )</span>
                                        <input type="number" class="form-control" id="repitiEjer" placeholder="Ejemplo: 20 o 50" /><br>
                                    </div>

                                    <div class="mb-6">
                                        <label class="form-label">Categoria: </label> <span class="help-form" id="helpcategoriaEjer"></span>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="categoriaEjer" required>
                                            <option value="" selected>-- Elija una categoria --</option>
                                            <option value="abdomen">Abdomen</option>
                                            <option value="brazo">Brazo</option>
                                            <option value="pierna">Pierna</option>
                                            <option value="gluteo">Gluteo</option>
                                            <option value="pierde peso">Perder Peso</option>
                                            <option value="define musculos">Definir Musculo</option>
                                        </select>
                                    </div>
                                    <div class="mb-6">
                                        <label class="form-label">Dia que se mostrara: </label> <span class="help-form" id="helpDia"></span>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="diaEJer" required>
                                            <option value="" selected> -- Elija un dia de la semana --</option>
                                            <option value="1">Lunes</option>
                                            <option value="2">Martes</option>
                                            <option value="3">Miercoles</option>
                                            <option value="4">Jueves</option>
                                            <option value="5">Viernes</option>
                                            <option value="6">Sabado</option>
                                            <option value="7">Domingo</option>

                                        </select>
                                    </div>
                                    <div class="mb-6">
                                        <label class="form-label">Nivel : </label> <span class="help-form" id="helpNivelEjer"></span>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="nivelEjer" required>
                                            <option value="" selected> -- Elija nivel del Ejercicio</option>
                                            <option value="principiante">Principiante</option>
                                            <option value="intermedio">Intermedio</option>
                                            <option value="experto">Experto</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="display: block;margin-left: auto;  margin-right: auto;" onclick="saveUserEjer()">Guardar <i class="fas fa-check"></i></button>
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
    <script src="../insertUserEjer.js"></script>
    <script src="../updateProfileUser.js"></script>

    <script>
        ///VALIDAR INPUT NOMBRE
        document.getElementById('nameEJer').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpNameEjer');
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
        document.getElementById('descripEJer').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpDescripEjer');
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
        document.getElementById('imgEjer').addEventListener('input', function() {
            var url = this.value;
            var helpText = document.getElementById('helpImgEjer');
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

        ///VALIDAR INPUT REPITICIONES
        document.getElementById('repitiEjer').addEventListener('input', function() {
            var inputValue = this.value;
            var helpText = document.getElementById('helpRepitiEjer');

            // Expresión regular para validar que sea un número de hasta 3 dígitos
            var regex = /^\d{1,3}$/;

            // Verificar si el valor ingresado cumple con la expresión regular
            if (regex.test(inputValue)) {
                // Convertir el valor ingresado a número para la comparación
                var numericValue = parseInt(inputValue);

                // Verificar si el valor numérico ingresado es entre 5 y 100
                if (numericValue >= 5 && numericValue <= 100) {
                    helpText.style.color = 'green';
                } else {
                    helpText.style.color = 'red';
                }
            } else {
                // Si no cumple, limpiar el valor y mostrar ayuda en rojo
                this.value = inputValue.slice(0, 3); // Mantener solo los primeros 3 caracteres
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