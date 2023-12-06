<!-- talvez borrar -->
<!DOCTYPE html>
<html lang="en">
<!-- // OBTENER VARIABLE DE SESSION , EN SU DEFECTO, MANDAR A LOGIN -->
<?php include 'getStorageScripts.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php include 'head.php'; ?>

<body id="page-top">
    <!-- Modal parameditar campos -->
    <div id="miModaledit" class="modalx">
        <div class="modal-contentx">
            <a href="#" class="close-button" onclick="cerrarModal()">×</a>
            <center>
                <h3>Editando - <span id="nameEdditing"></span></h3>
            </center>
            <div class="card-body">
                <div class="mb-3">
                    <input type="hidden" id="updateId">
                    <label class="form-label">Nombre del Ejercicio:</label> <span class="help-form" id="helpNameEjerUpdate">( Solo Letras, Números y Puntos. 3-50 caracteres )</span>
                    <input type="text" class="form-control" id="nombreUpdate" placeholder="Solo letras, Números y Puntos" /><br>
                    <br>

                    <label class="form-label">Descripcion del ejercicio:</label> <span class="help-form" id="helpDescripEjerUpdate">( Solo Letras, Números y Puntos. 3-200 caracteres )</span>
                    <input type="text" class="form-control" id="descripcionUpdate" placeholder="Solo letras, Números y Puntos" /><br>
                    <br>

                    <label class="form-label">Imagen a mostrar:</label> <span class="help-form" id="helpImgEjerUpdate">(Solo formatos URl)</span>
                    <input type="email" class="form-control" id="urlUpdate" placeholder="https://img/118dd170cec0f.gif" /><br>
                    <br>

                    <label class="form-label">Numero de repiticiones:</label> <span class="help-form" id="helpRepitiEjerUpdate">(Formato numero, máximo 3 caracteres, Valor minimo 5, valor máximo 100 )</span>
                    <input type="number" class="form-control" id="repeticionesUpdate" placeholder="Ejemplo: 20 o 50" /><br>
                </div>

                <div class="mb-6">
                    <label class="form-label">Categoria: </label> <span class="help-form" id="helpcategoriaEjerUpdate"></span>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="categoriaUpdate" required>
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
                    <label class="form-label">Dia que se mostrara: </label> <span class="help-form" id="helpDiaUpdate"></span>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="diaUpdate" required>
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
                    <label class="form-label">Nivel : </label> <span class="help-form" id="helpNivelEjerUpdate"></span>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="nivelUpdate" required>
                        <option value="" selected> -- Elija nivel del Ejercicio</option>
                        <option value="principiante">Principiante</option>
                        <option value="intermedio">Intermedio</option>
                        <option value="experto">Experto</option>
                    </select>
                </div>
                <a href="#" class="btn btn-primary" style="display: block;margin-left: auto;margin-right: auto;" onclick="updateUserEjer()">Guardar cambios</a>


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
                        <h1 class="h3 mb-1">Administrar Ejercicios</h1>
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
                                                <th>Nombre del Ejercicio</th>
                                                <th>Descripcion</th>
                                                <th>Fecha Agregado</th>
                                                <th>Imagen</th>
                                                <th>Repiticiones</th>
                                                <th>Categoria</th>
                                                <th>Dia que se mostrara</th>
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
    <script src="../showAppUsersEjer.js"></script>
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
    ///VALIDAR INPUT NOMBRE
    document.getElementById('nombreUpdate').addEventListener('input', function() {
        var password = this.value;
        var helpText = document.getElementById('helpNameEjerUpdate');
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
    document.getElementById('descripcionUpdate').addEventListener('input', function() {
        var password = this.value;
        var helpText = document.getElementById('helpDescripEjerUpdate');
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
    document.getElementById('urlUpdate').addEventListener('input', function() {
        var url = this.value;
        var helpText = document.getElementById('helpImgEjerUpdate');
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
    document.getElementById('repeticionesUpdate').addEventListener('input', function() {
        var inputValue = this.value;
        var helpText = document.getElementById('helpRepitiEjerUpdate');

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