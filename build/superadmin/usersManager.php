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
            <center>  <h3>Editando - <span id="nameEdditingUser"></span></h3>   </center>

            <div class="card-body">
                <div class="mb-3">
                    <input type="hidden" id="updateId">
                    <label class="form-label">Nombre</label><span class="help-form" id="helpName">( Solo Letras, Números y Puntos. 3-20 caracteres )</span>
                    <input type="text" class="form-control" id="updateName" placeholder="Nombre..." /><br>

                    <label class="form-label">Usuario</label><span class="help-form" id="helpUser">(Formato correo electrónico, máximo 30 caracteres )</span>
                    <input type="text" class="form-control" id="updateUser" placeholder="Correo electrónico..." /><br>

                    <div class="mb-6">
                    <label class="form-label">Status: </label> <span class="help-form" id="helpStatus"></span>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="updateStatus" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select> 
                                <div class="mb-6">
                                    <label class="form-label" id="updatePlanLabel">Plan: </label> <span class="help-form" id="helpPlan"></span>
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="updatePlan" required>
                                        <option value="" selected>-- Elija el Plan</option>
                                        <option value="Biceps Start">Biceps Start</option>
                                        <option value="Biceps Plus">Biceps Plus</option>
                                    </select>
                                </div>
                </div>

                </div><br>
                <a href="#"  class="btn btn-primary"  style="display: block;margin-left: auto;margin-right: auto; width:280px;" onclick="updateUser()">Guardar cambios</a>
            
                   
            </div>
        </div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'menu.php'; ?> 
        <div id="content-wrapper" class="d-flex flex-column"> 
            <div id="content">
                <?php include 'barTop.php'; ?> 
                <div class="container-fluid"> 
                    <center>  <h1 class="h3 mb-1">Administrar Usuarios </h1> </center>

                    <div class="card position-relative" style="margin-top:20px;">

                        <!-- DataTales Example -->
                        <div class=" ">
                            <div class=" ">
                                <label for="filtroSelect">
                                    <center style="margin-top:10px;">Filtrar por:</center>
                                    <div class="filerTable" style="margin-top:10px;">
                                        <select id="filtroSelect" onchange="manejarCambioFiltro(this.value)" class="btn btn-primary" style="margin-left:10px; margin-right:10px">
                                            <option value="todos">Todos</option>
                                            <option value="superAdmin">Administradores</option>
                                            <option value="admin">Gimnasios</option>
                                        </select>
                                    </div>
                                </label>

                          

                                <label style="float: right;">Buscar: <input type="text" id="buscar" onkeyup="buscar()"
                                        placeholder=" Buscar en la tabla..." title="Empieza a escribir para buscar"
                                        style="margin:20px;border-radius: 5px;">
                                </label>

                                <div class="table-responsive" style="text-align: center;">
                                    <table class="table" id="tabla" data-sort="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>usuario</th>
                                                <th>Fecha Agregado</th>
                                                <th>Tipo Usuario</th>
                                                <th>Status</th>
                                                <th>Acciones</th> 
                                                <th>Plan Actual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
    <script src="../showUsers.js"></script>
    <script src="../updateProfile.js"></script>

    

    
 
</body>
 




<script>
    /* SELECT TABLA */
                            function manejarCambioFiltro(valor) {
                                        switch (valor) {
                                            case 'todos':
                                                cargarDatosGral();
                                                break;
                                            case 'superAdmin':
                                                cargarDatosSuperAdmin();
                                                break;
                                            case 'admin':
                                                cargarDatosAdmin();
                                                break;
                                            default: 
                                                break;
                                        }
                                    }

    /* FUNCION BUSQUEDA */
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

        $("#tabla tbody tr").each(function () {
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
        $("#tabla td").each(function () {
            var textoEnTd = $(this).text().toUpperCase();
            if (textoEnTd.indexOf(filtro) >= 0) {
                $(this).addClass("existe");
            } else {
                $(this).removeClass("existe");
            }
        })

        $("#tabla tbody tr").each(function () {
            if ($(this).children(".existe").length > 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        })

    }

    function busquedaJQmultiple() {
        var filtro = $("#buscar").val().toUpperCase();

        $("#tabla tbody tr").each(function () {

            $(this).children("td").each(function () {
                var texto = $(this).text().toUpperCase();

                if (texto.indexOf(filtro) < 0) {
                    $(this).addClass("sin");
                } else {
                    $(this).removeClass("sin");
                }
            }); 
            nTds = $(this).children("td").length 
            nTdsSin = $(this).children(".sin").length

            if (nTdsSin == nTds) { 
                $(this).addClass("noTiene");
            } else { 
                $(this).removeClass("noTiene");
            }

        });

    }



 
            //==============================VALIDACIONES INPUT   ============================//

        
            ///VALIDAR INPUT NOMBRE
            document.getElementById('updateName').addEventListener('input', function() {
                var password = this.value;
                var helpText = document.getElementById('helpName');
                var regex = /^[a-zA-Z0-9. ]+$/;
                var maxLengthPass = 21;

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
                var helpText = document.getElementById('helpUser');
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

   

</script>

<style>
            .help-form {
        margin-left: 42px;
        font-size: 14px;
        font-weight: 600;
    }
    .noTiene {
        display: none
    }

    /* Estilos para el Switch */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Estilos para el slider */
.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Forma redonda para el slider */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>

</html>