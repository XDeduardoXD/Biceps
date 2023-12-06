 
document.addEventListener('DOMContentLoaded', function() {
    // Configurar el evento de clic para el botón de cierre de sesión
    document.getElementById('logoutButton').addEventListener('click', function() {
        cerrarSesion();
    });

    var user = localStorage.getItem('user');
    if(user) {
        document.getElementById('userDisplay').textContent = user;
    } else { 
        window.location.href = "../index";
    }
});

function cerrarSesion() {
    // Limpiar localStorage
    localStorage.removeItem('usuario_logeado');
    localStorage.removeItem('userType');
    localStorage.removeItem('user');
    localStorage.removeItem('usergym');
    localStorage.removeItem('idDoc');
 
    window.location.href = "../index";
}
 
// function cerrarSesion() { 
//     localStorage.clear(); 
//     window.location.href = "../index";
// }