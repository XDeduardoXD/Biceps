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
                        <h1 class="h3 mb-1">Agregar Tip de Nutrición</h1>
                    </center>
                    <div>

                        <div>
                            <div class="card position-relative">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre Tip:</label> <span class="help-form" id="helpNameTip">Solo Letras, Números y Puntos. 3-50 caracteres</span>
                                        <input type="text" class="form-control" id="nameTip" placeholder="Solo letras, Números y Puntos" /><br>
                                        <br>

                                        <label class="form-label">Descripcion del Tip:</label> <span class="help-form" id="helpDesTip">Solo Letras, Números y Puntos. 3-200 caracteres</span>
                                         <textarea class="form-control" id="descripTip" placeholder="Solo letras, Números y Puntos" rows="3"></textarea>
                                        <br>

                                        <label class="form-label">Imagen ilustrativa:</label> <span class="help-form" id="helpImgTip">Solo formatos URl</span>
                                        <input type="email" class="form-control" id="imgTip" placeholder="https://img/118dd170cec0f.gif" /><br>
                                        <br>  
                                    </div>

                                    <label class="form-label">Establecer un Índice de Masa Corporal (IMC) Minimo y Máximo al que ira dirigido este Tip </label> 
                                    <span style="float:right; margin-right:50px" class="help-form" id="helpImcTip"> </span> 
                                    <span style="float:right; margin-right:50px" class="help-form" id="helpImcMin"> </span>
                                    <span style="float:right; margin-right:50px" class="help-form" id="helpImcMax"> </span>
                                    <div class="input-group mb-3"><span class="input-group-text">IMC MIN</span>
                                        <input type="text" class="form-control" placeholder="Solo Números"  id="MinImc">
                                        <span class="input-group-text">IMC MAX</span> 
                                        <input type="text" class="form-control" placeholder="Solo Números" id="MaxImc">
                                    </div>

                             
                             

                                    <button type="submit" class="btn btn-primary" style="display: block;margin-left: auto;  margin-right: auto;" onclick="saveTip()">Guardar <i class="fas fa-check"></i></button>
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
    <script src="../insertTip.js"></script>
    <script src="../updateProfileUser.js"></script>

    <script>
        ///VALIDAR INPUT NOMBRE
        document.getElementById('nameTip').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpNameTip');
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
        document.getElementById('descripTip').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpDesTip');
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
        document.getElementById('imgTip').addEventListener('input', function() {
            var url = this.value;
            var helpText = document.getElementById('helpImgTip');
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




        
        ///VALIDAR INPUT IMC
        
    document.getElementById('MinImc').addEventListener('input', function() {
        validarImc('MinImc', 'helpImcMin');
        compararImc();
    });

    document.getElementById('MaxImc').addEventListener('input', function() {
        validarImc('MaxImc', 'helpImcMax');
        compararImc();
    });

    document.getElementById('MinImc').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, ''); // Remueve todo lo que no sea dígito
    });

    document.getElementById('MaxImc').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, ''); // Remueve todo lo que no sea dígito
    });

    document.getElementById('MinImc').addEventListener('input', function() {
        limitarADosNumeros(this);
    });

    document.getElementById('MaxImc').addEventListener('input', function() {
        limitarADosNumeros(this);
    });

    function limitarADosNumeros(input) {
        input.value = input.value.replace(/\D/g, '').slice(0, 2); // Solo dígitos y limita a 2 caracteres
    }


    function validarImc(inputId, helpTextId) {
        var imc = document.getElementById(inputId).value;
        var helpText = document.getElementById(helpTextId);
        var regex = /^\d*\.?\d*$/; // Permite números y puntos para decimales

        if (regex.test(imc)) {
            helpText.textContent = ""; // No hay error
            helpText.style.color = 'green';
        } else {
            helpText.textContent = "Solo números permitidos";
            helpText.style.color = 'red';
        }
    }

    function compararImc() {
        var minImc = parseFloat(document.getElementById('MinImc').value);
        var maxImc = parseFloat(document.getElementById('MaxImc').value);
        var helpTextMax = document.getElementById('helpImcMax');

        if (!isNaN(minImc) && !isNaN(maxImc) && maxImc <= minImc) {
            helpTextMax.textContent = "IMC MAX debe ser mayor que IMC MIN";
            helpTextMax.style.color = 'red';
        } else {
            helpTextMax.textContent = ""; // No hay error
            helpTextMax.style.color = 'green';
        }
    }




 
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