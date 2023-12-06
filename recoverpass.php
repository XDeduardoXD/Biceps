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
  <script>
    Swal.fire({
      icon: 'info',
      title: 'Atención',
      text: 'Solo podra enviar una vez el correo de recuperacion.'
    })
  </script>


  <div class="login-container">

    <div class="login-form">
      <div class="login-form-inner">
        <center>
          <h1>BICEPS | Ayuda con la contraseña</h1>
          <p class="body-text">¡Conéctate a tu mejor versión!</p><br>
          <b>
            <p style='color: red;'>¡Solo podra enviar una vez el correo de recuperacion!</p>
          </b>
        </center>

        <div class="sign-in-seperator">
          <span> - </span>
        </div>

        <div class="login-form-group">
          <input type="text" id="user" class="cajatexto" placeholder="Ingresar Email" maxlength="30" />
        </div>

        <a href="#" class="rounded-button login-cta" id="recoverButton" onclick="validateAndRecover()">Recuperar</a>


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
  <script src="recovery.js"></script>


  <script>
    function validateAndRecover() {
      var email = document.getElementById('user').value;
      // Expresión regular para validar el formato del correo electrónico
      var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

      if (emailRegex.test(email)) {
        recoverPassword();
        document.getElementById('recoverButton').style.display = 'none';
        var now = new Date().getTime();
        localStorage.setItem('recoverButtonPressedTime', now);
      } else {
        // Opcional: muestra un mensaje de error si el correo no es válido
        Swal.fire({
          icon: "error",
          title: "Campos Vacios.",
          text: "Debe ingresar un Correo Electronico correcto, para mandarle su correo de recuperacion."
        })
        Swal.fire({ icon: "error", title: "Error", text: "Error datos faltantes"});
      }
    }

    window.onload = function() {
      var recoverButtonPressedTime = localStorage.getItem('recoverButtonPressedTime');
      var now = new Date().getTime();

      var timeLimit = 300000; // 5 minutos en milisegundos

      if (recoverButtonPressedTime && now - recoverButtonPressedTime < timeLimit) {
        document.getElementById('recoverButton').style.display = 'none';
      } else {
        document.getElementById('recoverButton');
      }
    }
  </script>
</body>

</html>