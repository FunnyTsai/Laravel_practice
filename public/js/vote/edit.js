function show(){   
    var info = JSON.parse(document.getElementById('vote_info').getAttribute('data-info'));

    var voteDetails = document.getElementById('voteDetails');
    
    let voteCount = 0;

    info.forEach(function(item) {

        voteCount++;
        
        const newDiv = document.createElement('div');
        newDiv.classList.add(`vote_info${voteCount}`);

        newDiv.innerHTML = `
                        <div class="row g-4 mb-6 vote-info">
                            <div class="card">
                                <h5 class="card-header">序號${voteCount}</h5>
                                <div class="card-body">
                                    <label for="TITLE" class="form-label">內容</label>
                                    <input class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE]" required value="${item['VOTE_TITLE']}">
                                    <div class="col-sm-11">
                                        <label for="TITLE_DESC" class="form-label">描述</label>
                                        <textarea class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE_DESC]" required>${item['VOTE_TITLE_DESC']}</textarea>
                                    </div>
                                    <button type="button" class="btn btn-danger deleteBtn">刪除</button>
                                </div>
                            </div>
                        </div>
                    `;

        voteDetails.appendChild(newDiv); 
    });
}

$(function() {
    show();

    var end_date = document.getElementById("END_DATE").value;
    var inputs = document.querySelectorAll('input, textarea');

    var endDate = new Date(end_date);
    var currentDate = new Date();

    // 超過投票時間的不得編輯
    if (currentDate > endDate) {
        inputs.forEach(function(element) {
            element.disabled = true;
        });

        $("#voteSubmit").hide();
        $(".deleteBtn").hide();
        $(".submitBtn").hide();
        $(".departmentBtn").hide();
    } 
    else {
    }
    
    // 加入按鈕
    $('#btnAdd').click(function() {
        $('#allDepartments option:selected').appendTo('#selectedDepartments');
    });

    // 退回按鈕
    $('#btnRemove').click(function() {
        $('#selectedDepartments option:selected').appendTo('#allDepartments');
    });

    // 確認按鈕
    $('#selectDepartments').click(function() {
        var selectedValues = [];
        var selectedNames = [];

        $('#selectedDepartments option').each(function() {
            selectedValues.push($(this).val());
            selectedNames.push($(this).data('deptname'));
        });

        // console.log("selectedValues",selectedValues);        
        // console.log("selectedNames",selectedNames);

        $('#departmentInput').val(selectedNames.join(', '));
        $('#deptcodesCodeInput').val(selectedValues.join(','));
        $('#departmentModal').modal('hide');
    }); 

    // 全部加入按鈕
    $('#btnAddAll').click(function() {
        $('#allDepartments option').appendTo('#selectedDepartments');
    });

    // 全部退回按鈕
    $('#btnRemoveAll').click(function() {
        $('#selectedDepartments option').appendTo('#allDepartments');
    });
})