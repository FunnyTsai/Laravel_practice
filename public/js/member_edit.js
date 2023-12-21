function showGroup(){  
    // 編輯頁面自動代入目前有的群組    
    var groupInfo = JSON.parse(document.getElementById('groupInfo').getAttribute('data-info'));

    // 獲取要顯示群組的 ul 元素
    var groupList = document.getElementById('groupList');

    groupInfo.forEach(function(item) {
        var groupName = item.PHR_NAME;
    
        var newItem = document.createElement('li');
        newItem.className = 'list-group-item d-flex justify-content-between lh-sm';
        newItem.innerHTML = `
                                <input class="my-0" name="selected_groups[]" placeholder="${groupName}" value="${groupName}" readonly>
                                <button type="button" class="btn btn-danger btn-sm deleteBtn">刪除</button>
                            `;

        groupList.appendChild(newItem);
    });
}

$(function() {
    showGroup();
    
    // var listItems = document.querySelectorAll('#groupList li');

    // var h6Contents = [];

    // listItems.forEach(function(listItem) {
    //     var h6Element = listItem.querySelector('h6');
    //     var h6Content = h6Element.textContent.trim();
    //     h6Contents.push(h6Content);
    // });

    // // 打印或使用 h6Contents 這個包含所有 <h6> 元素內容的數組
    // console.log(h6Contents);

    // document.getElementById('saveButton').addEventListener('click', function(event) {
    //     // 防止表單直接提交
    //     event.preventDefault();

    //     var listItems = document.querySelectorAll('#groupList li');
    //     var h6Contents = [];

    //     listItems.forEach(function(listItem) {
    //         var h6Element = listItem.querySelector('h6');
    //         var h6Content = h6Element.textContent.trim();
    //         h6Contents.push(h6Content);
    //     });

    //     var user_id  = document.getElementById('user_id').value;

    //     // 處理表單數據
    //     var formData = new FormData();
    //     formData.append('user_id', user_id);
    //     for (var i = 0; i < h6Contents.length; i++) {
    //         formData.append('groupContent[]', h6Contents[i]);
    //     }
    
    //     // 發送 AJAX 請求到 '/save_data' 路由
    //     axios.post('/save_data', formData)
    //         .then(function(response) {
    //             // 成功處理請求後的操作
    //             console.log(response.data, '成功發送數據到 Controller');
    //             // 繼續執行表單提交
    //             document.querySelector('form').submit();
    //         })
    //         .catch(function(error) {
    //             // 處理錯誤
    //             console.error(error, '請求發送失敗');
    //             // 在這裡可以顯示錯誤訊息給用戶
    //         });

    //     // console.log(user_id);
    //     // console.log(h6Contents);

    //     // $.ajaxSetup({
    //     //     headers: {
    //     //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     //     }
    //     // });
        

    //     // // 使用 AJAX 發送 POST 請求到您的 Controller
    //     // $.ajax({
    //     //     type: 'POST',
    //     //     url: '/save_data',
    //     //     data: {
    //     //         user_id: user_id,
    //     //         groupContent: h6Contents
    //     //     },
    //     //     success: function(response) {
    //     //         // 成功處理請求後的操作
    //     //         console.log(response,'成功發送數據到 Controller');
    //     //         // 繼續執行表單提交
    //     //         document.querySelector('form').submit();
    //     //     },
    //     //     error: function(error) {
    //     //         // 處理錯誤
    //     //         console.error(error,'請求發送失敗');
    //     //     }
    //     // });
        
    // });

})