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
            <div>
                <h6 class="my-0">${groupName}</h6>
            </div>
            <button type="button" class="btn btn-danger btn-sm deleteBtn">刪除</button>
        `;
    
        groupList.appendChild(newItem);
    });
}

$(function() {
    showGroup();
    
    var listItems = document.querySelectorAll('#groupList li');

    var h6Contents = [];

    listItems.forEach(function(listItem) {
        var h6Element = listItem.querySelector('h6');
        var h6Content = h6Element.textContent.trim();
        h6Contents.push(h6Content);
    });

    // 打印或使用 h6Contents 這個包含所有 <h6> 元素內容的數組
    console.log(h6Contents);
})