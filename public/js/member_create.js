
// function common(buttonId, passwordId) {
//     var togglePassword = document.getElementById(`${buttonId}`);
//     var password = document.getElementById(`${passwordId}`);

//     togglePassword.addEventListener('click', function () {
//         var type = password.getAttribute('type') === 'password' ? 'text' : 'password';
//         password.setAttribute('type', type);

//         this.classList.toggle('fa-eye');
//     });
//   }

$(function() {

    var togglePassword = document.getElementById('togglePassword');
    var password = document.getElementById('user_password1');

    togglePassword.addEventListener('click', function () {
        var type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        this.classList.toggle('fa-eye');
    });


    var togglePassword2 = document.getElementById('togglePassword2');
    var password2 = document.getElementById('user_password2');

    togglePassword2.addEventListener('click', function () {
        var type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
        password2.setAttribute('type', type);

        this.classList.toggle('fa-eye');
    });
});