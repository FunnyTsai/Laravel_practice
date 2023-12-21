
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

    // 按下新增按鈕時新增群組<li>
    $(document).on('click', '#groupSubmit', function(event) {
        event.preventDefault(event);
        var groupName = $('#group').val();

        // 先檢查這個 groupName 是否有存在於目前的 name="selected_groups[]" 元素的 value 中
        var exists = $("input[name='selected_groups[]'][value='" + groupName + "']").length > 0;

        if (groupName.trim() !== '' && !exists) {
            var newItem = '<li class="list-group-item d-flex justify-content-between lh-sm">' +
                            '<input type="hidden" name="selected_groups[]" value="' + groupName + '">' +
                            '<input class="my-0" placeholder="' + groupName + '" value="' + groupName + '" readonly>' +
                            '<button type="button" class="btn btn-danger btn-sm deleteBtn">刪除</button>' +
                            '</li>';

            $('#groupList').append(newItem);

            $('#group').val('');
        }
        else{
            alert("請勿輸入重複的群組或空群組！");
        }

        updateGroupCount();
    });

    // 點擊刪除按鈕時刪除群組<li>
    $(document).on('click', '.deleteBtn', function() {
        $(this).closest('li').remove();

        updateGroupCount();
    });

    // 點擊群組的數字
    function updateGroupCount() {
        var groupCount = $('#groupList li').length;
        $('#groupCountBadge').text(groupCount);
    }

});