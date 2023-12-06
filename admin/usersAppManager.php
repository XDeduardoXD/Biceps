<!-- talvez borrar -->
<!DOCTYPE html>
<html lang="en">
<!-- // OBTENER VARIABLE DE SESSION , EN SU DEFECTO, MANDAR A LOGIN -->
<?php include 'getStorageScripts.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php include 'head.php'; ?>

<body id="page-top">

    <div id="miModaledit" class="modalx">
        <div class="modal-contentx">
            <a href="#" class="close-button" onclick="cerrarModal()">×</a>
            <center>
                <h3>Editando - <span id="nameEdditing"></span></h3>
            </center>
            <div class="card-body">
                <div class="mb-3">
                    <input type="hidden" id="updateId">
                    <label class="form-label">Nombre</label><span class="help-form" id="helpNameUpdateUser">( Solo Letras, Números y Puntos. 3-50 caracteres )</span>
                    <input type="text" class="form-control" id="updateName" placeholder="Nombre..." /><br>

                    <label class="form-label">Usuario</label><span class="help-form" id="helpUserUpdateUser">(Formato correo electrónico, máximo 30 caracteres )</span>
                    <input type="text" class="form-control" id="updateUser" placeholder="Correo electrónico..." /><br>

                    <label class="form-label">Peso:</label> <span class="help-form" id="helpUserUpdatePeso">(Formato numero, máximo 5 caracteres, valor máximo 250 )</span>
                    <input type="text" class="form-control" id="updatePeso" placeholder="Ejemplo: 50.5 o 50" /><br>
                    <br>

                    <label class="form-label">Altura:</label> <span class="help-form" id="helpUserUpdateAltura">(Formato numero, máximo 4 caracteres , valor máximo 2.50)</span>
                    <input type="text" class="form-control" id="UpdateAltura" placeholder="Ejemplo: 1.50" /><br>
                    <br>

                    <div class="mb-6">
                        <label class="form-label">Status: </label> <span class="help-form" id="helpStatus"></span>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="updateStatus" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div><br>

                    <div class="mb-6">
                        <label class="form-label">Nivel : </label> <span class="help-form" id="helpUpdateNivel"></span>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="updateNivelUser" required>
                            <option value="" selected> -- Elija nivel del usuario</option>
                            <option value="principiante">Principiante</option>
                            <option value="intermedio">Intermedio</option>
                            <option value="experto">Experto</option>
                        </select>
                    </div>

                </div>
                <a href="#" class="btn btn-primary" style="display: block;margin-left: auto;margin-right: auto;" onclick="updateUser()">Guardar cambios</a>


            </div>
        </div>
    </div>

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
                    <!-- Page Heading -->
                    <center>
                        <h1 class="h3 mb-1">Administrar Usuarios</h1>
                    </center>

                    <div class="card position-relative" style="margin-top:20px;">

                        <!-- DataTales Example -->
                        <div class=" ">
                            <div class=" ">

                                <label style="float: right;">Buscar: <input type="text" id="buscar" onkeyup="buscar()" placeholder=" Buscar en la tabla..." title="Empieza a escribir para buscar" style="margin:20px;border-radius: 5px;">
                                </label>

                                <div class="table-responsive" style="text-align: center;">
                                    <table class="table" id="tabla" data-sort="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>usuario</th>
                                                <th>Fecha Agregado</th>
                                                <th>Status</th>
                                                <th>Peso</th>
                                                <th>Altura</th>
                                                <th>IMC</th>
                                                <th>Nivel</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br><br>
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
    <?php include 'scripts.php'; ?>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore-compat.js"></script>
    <script src="../logOut.js"></script>
    <script src="../showAppUsers.js"></script>
    <script src="../updateProfileUser.js"></script>
</body>








<script>
    /* W3 Example */
    function busqueda() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("buscar");
        filter = input.value.toUpperCase();
        table = document.getElementById("tabla");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function busquedaJQsimple() {
        var filtro = $("#buscar").val().toUpperCase();

        $("#tabla tbody tr").each(function() {
            texto = $(this).children("td:eq(0)").text().toUpperCase();

            if (texto.indexOf(filtro) < 0) {
                $(this).hide();
            } else {
                $(this).show();
            }


        });

    }

    function buscar() {

        var filtro = $("#buscar").val().toUpperCase();

        $("#tabla td").each(function() {
            var textoEnTd = $(this).text().toUpperCase();
            if (textoEnTd.indexOf(filtro) >= 0) {
                $(this).addClass("existe");
            } else {
                $(this).removeClass("existe");
            }
        })

        $("#tabla tbody tr").each(function() {
            if ($(this).children(".existe").length > 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        })

    }

    function busquedaJQmultiple() {
        var filtro = $("#buscar").val().toUpperCase();

        $("#tabla tbody tr").each(function() {

            $(this).children("td").each(function() {
                var texto = $(this).text().toUpperCase();

                if (texto.indexOf(filtro) < 0) {
                    $(this).addClass("sin");
                } else {
                    $(this).removeClass("sin");
                }
            });

            // nTds = la cantidad de <td> en el <tr> evaluado
            nTds = $(this).children("td").length
            // nTdsSin = la cantidad de <td> con la clase ".sin" en el <tr> evaluado
            nTdsSin = $(this).children(".sin").length

            if (nTdsSin == nTds) {
                //$(this).hide()
                $(this).addClass("noTiene");
            } else {
                //$(this).show()
                $(this).removeClass("noTiene");
            }

        });

    }
</script>









<script>
    //==============================VALIDACIONES INPUT   ============================//


    ///VALIDAR INPUT NOMBRE
    document.getElementById('updateName').addEventListener('input', function() {
        var password = this.value;
        var helpText = document.getElementById('helpNameUpdateUser');
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
    document.getElementById('updateUser').addEventListener('input', function() {
        var email = this.value;
        var helpText = document.getElementById('helpUserUpdateUser');
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

    //VALIDAR PESO 
    document.getElementById('updatePeso').addEventListener('input', function() {
            var peso = this.value;
            var helpText = document.getElementById('helpUserUpdatePeso');
 
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
        document.getElementById('UpdateAltura').addEventListener('input', function() {
            var altura = this.value;
            var helpText = document.getElementById('helpUserUpdateAltura');
 
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




<style>
    .noTiene {
        display: none
    }

    .help-form {
        margin-left: 42px;
        font-size: 14px;
        font-weight: 600;
    }
</style>

</html>