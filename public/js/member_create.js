


$(function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const icon = document.getElementById('togglePasswordIcon');

    togglePassword.addEventListener('click', function () {
        // 切換密碼輸入框的 type 屬性
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
    });
});