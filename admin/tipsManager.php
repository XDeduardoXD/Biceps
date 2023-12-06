<!-- talvez borrar -->
<!DOCTYPE html>
<html lang="en">
<!-- // OBTENER VARIABLE DE SESSION , EN SU DEFECTO, MANDAR A LOGIN -->
<?php include 'getStorageScripts.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php include 'head.php'; ?>

<body id="page-top">
    <!-- Modal parameditar campos -->
    <div id="miModaleditTip" class="modalx">
        <div class="modal-contentx">
            <a href="#" class="close-button" onclick="cerrarModalTip()">×</a>
            <center>
                <h3>Editando - <span id="nameEdditingTip"></span></h3>
            </center>
            <div class="card-body">
                <div class="mb-3">
           <input type="hidden" id="updateIdTip">
                <label class="form-label">Nombre Tip:</label> <span class="help-form" id="helpNameTipUpd">Solo Letras, Números y Puntos. 3-50 caracteres</span>
                                        <input type="text" class="form-control" id="tipUpd" placeholder="Solo letras, Números y Puntos" /><br>
                                        <br>

                                        <label class="form-label">Descripcion del Tip:</label> <span class="help-form" id="helpDesTipUpd">Solo Letras, Números y Puntos. 3-200 caracteres</span>
                                         <textarea class="form-control" id="desTipUpd" placeholder="Solo letras, Números y Puntos" rows="3"></textarea>
                                        <br>

                                        <label class="form-label">Imagen ilustrativa:</label> <span class="help-form" id="helpImgTipUpd">Solo formatos URl</span>
                                        <input type="email" class="form-control" id="urlTipUpd" placeholder="https://img/118dd170cec0f.gif" /><br>
                                        <br>  
                                    </div>

                                    <label class="form-label">Establecer un Índice de Masa Corporal (IMC) Minimo y Máximo al que ira dirigido este Tip </label> 
                                    <span style="float:right; margin-right:50px" class="help-form" id="helpImcTipUpd"> </span> 
                                    <span style="float:right; margin-right:50px" class="help-form" id="helpImcMinUpd"> </span>
                                    <span style="float:right; margin-right:50px" class="help-form" id="helpImcMaxUpd"> </span>
                                    <div class="input-group mb-3"><span class="input-group-text">IMC MIN</span>
                                        <input type="text" class="form-control" placeholder="Solo Números"  id="imcMinTipUpd">
                                        <span class="input-group-text">IMC MAX</span> 
                                        <input type="text" class="form-control" placeholder="Solo Números" id="imcMaxTipUpd">
                                    </div>


                <a href="#" class="btn btn-primary" style="display: block;margin-left: auto;margin-right: auto;" onclick="updateTip()">Guardar cambios</a>


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
                        <h1 class="h3 mb-1">Administrar Tips de Nutrición</h1>
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
                                                <th>Nombre del Tip</th>
                                                <th>Descripcion</th>
                                                <th>Fecha Agregado</th>
                                                <th>Imagen</th>  
                                                <th>Min IMC</th>  
                                                <th>Max IMC</th>    
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
    <script src="../showTips.js"></script>
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
       document.getElementById('tipUpd').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpNameTipUpd');
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
        document.getElementById('desTipUpd').addEventListener('input', function() {
            var password = this.value;
            var helpText = document.getElementById('helpDesTipUpd');
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
        document.getElementById('urlTipUpd').addEventListener('input', function() {
            var url = this.value;
            var helpText = document.getElementById('helpImgTipUpd');
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
        document.getElementById('imcMinTipUpd').addEventListener('input', function (e) {
    var value = e.target.value;
    if (value.length > 2 || !/^\d*$/.test(value)) {
        e.target.value = value.slice(0, -1);
    }
});

document.getElementById('imcMaxTipUpd').addEventListener('input', function (e) {
    var value = e.target.value;
    if (value.length > 2 || !/^\d*$/.test(value)) {
        e.target.value = value.slice(0, -1);
    }
});


 
 
        ///VALIDAR INPUT IMC
        function validarImc(minInputId, maxInputId, helpTextId) {
    var imcMin = parseFloat(document.getElementById(minInputId).value);
    var imcMax = parseFloat(document.getElementById(maxInputId).value);
    var helpText = document.getElementById(helpTextId);
    var regex = /^\d*\.?\d*$/; // Permite números y puntos para decimales

    // Primero valida que ambos campos sean números
    if (regex.test(imcMin) && regex.test(imcMax)) {
        // Ahora verifica que el IMC mínimo sea menor que el IMC máximo
        if (imcMin >= imcMax) {
            helpText.textContent = "Error: El IMC mínimo debe ser menor que el IMC máximo";
            helpText.style.color = 'red';
        } else {
            helpText.textContent = ""; // No hay error
            helpText.style.color = 'green';
        }
    } else {
        helpText.textContent = "Solo números permitidos";
        helpText.style.color = 'red';
    }
}

// Llama a esta función cada vez que los valores de los campos IMC cambien
document.getElementById('imcMinTipUpd').addEventListener('input', function() {
    validarImc('imcMinTipUpd', 'imcMaxTipUpd', 'helpImcTipUpd');
});

document.getElementById('imcMaxTipUpd').addEventListener('input', function() {
    validarImc('imcMinTipUpd', 'imcMaxTipUpd', 'helpImcTipUpd');
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