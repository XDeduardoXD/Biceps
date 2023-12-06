<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.0/js/swiper.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/style.css" />
</head>
<body>


   <script>  Swal.fire({  icon: 'info',  title: 'Atención', text: 'Solo podrá hacer cambios una sola vez'  })  </script>

  <div class="login-container">

    <div class="login-form">
      <div class="login-form-inner">
        <center>
          <h1>BICEPS | Nueva contraseña</h1>
          <p class="body-text">¡Conéctate a tu mejor versión!</p><br><b>
            <p style='color: red;'>¡Solo podra hacer esta accion una vez!</p>
          </b>
        </center>

        <div class="sign-in-seperator">
          <span> - </span>
        </div>



        <div class="login-form-group">
          <input type="hidden" id="user" class="cajatexto" placeholder="Ingresar Email" maxlength="30" /> <br>
          <input type="password" id="pass" class="cajatexto" placeholder="Ingresar contraseña nueva" maxlength="30" />
        </div>

        <a href="#" class="rounded-button login-cta" id="saveButton" onclick="newPass()">Guardar cambios</a>


        <div class="login-form-group single-row" style="justify-content: center">
          <a href="index" class="link forgot-link">Iniciar sesión</a>
        </div><br><br><br><br><br><br><br>
      </div>
    </div>

    <div class="onboarding">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide color-1">
            <div class="slide-image">
              <img src="assets/img/logo.jpg" loading="lazy" alt="" />
            </div>
          </div>
          <div class="swiper-slide color-1">
            <div class="slide-image">
              <img src="assets/img/logo2.jpg" loading="lazy" alt="" />
            </div>
          </div>

          <div class="swiper-slide color-1">
            <div class="slide-image">
              <img src="assets/img/logo3.jpg" loading="lazy" alt="" />
            </div>
          </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <?php
    $current_url = $_SERVER['REQUEST_URI'];

    // Analiza la URL para obtener sus parámetros
    $url_components = parse_url($current_url);
    parse_str($url_components['query'], $params);

    // Obtén el valor del parámetro "token"
    $token = $params['token'];


    ?>
  </div>

  <script>
    var swiper = new Swiper(".swiper-container", {
      pagination: ".swiper-pagination",
      paginationClickable: true,
      parallax: true,
      speed: 600,
      autoplay: 3500,
      loop: true,
      grabCursor: true
    });
  </script>

  <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore-compat.js"></script>
  <script src="firebaseAccess.js"></script>
  <script src="new-pass.js"></script>

  <script>
    // Función para validar los campos de entrada
    function validateInputs() {
    var pass = document.getElementById('pass').value;

    var isLengthValid = pass.length >= 8; // Longitud mínima de 8 caracteres
    var hasUpperCase = /[A-Z]/.test(pass); // Al menos una letra mayúscula
    var hasLowerCase = /[a-z]/.test(pass); // Al menos una letra minúscula
    var hasNumbers = /\d/.test(pass); // Al menos un número
    var hasNoSpecialChar  = /^[a-zA-Z0-9]*$/.test(password); // Al menos un carácter especial

    // Verifica todas las condiciones
    var isPasswordValid = isLengthValid && hasUpperCase && hasLowerCase && hasNumbers && hasNoSpecialChar;

    // Muestra mensajes de error si es necesario
    if (!isPasswordValid) {
        var errorMessage = "La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula y un número, Sin caracteres especiales";
        Swal.fire({ icon: "error", title: "Contraseña inválida", text: errorMessage });
        return false;
    }
    
    return true; // Si todas las validaciones son correctas
}


    // Función que se llama al hacer clic en el botón
    function validateAndSave() {
      if (validateInputs()) {
        newPass(); // Tu función para guardar los cambios
        document.getElementById('saveButton').style.display = 'none';
        var now = new Date().getTime();
        localStorage.setItem('buttonPressedTime', now);
    } else {
        // Los mensajes de error ya son manejados en validateInputs()
    }
    }

    // Verificar el estado del botón al cargar la página
    window.onload = function() {
      var buttonPressedTime = localStorage.getItem('buttonPressedTime');
      var now = new Date().getTime();

      // Establece el tiempo durante el cual el botón permanecerá desactivado (ejemplo: 1 hora)
      var timeLimit = 300000; // 5 minutos en milisegundos

      if (buttonPressedTime && now - buttonPressedTime < timeLimit) {
        document.getElementById('saveButton').style.display = 'none';
      } else {
        document.getElementById('saveButton');
      }
    }
  </script>
</body>

</html>