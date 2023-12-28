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
                                <div class="row align-items-center">
                                    <h5 class="card-header d-flex justify-content-between align-items-center">
                                        <span>選項${voteCount}</span>
                                        <button type="button" class="btn btn-danger deleteBtn">刪除</button>
                                    </h5>                            
                                </div>
                                <div class="card-body">
                                    <label for="TITLE" class="form-label">內容</label>
                                    <input class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE]" required value="${item['VOTE_TITLE']}">
                                    <div class="col-sm-11">
                                        <label for="TITLE_DESC" class="form-label">描述</label>
                                        <textarea class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE_DESC]" required>${item['VOTE_TITLE_DESC']}</textarea>
                                    </div>                                    
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
    var vote_user = document.getElementById("VOTE_USER").value;

    var endDate = new Date(end_date);
    var currentDate = new Date();

    // 超過投票時間並且已有人投票的不得編輯
    if (currentDate > endDate && vote_user) {
        inputs.forEach(function(element) {
            if (element.id !== "START_DATE" && element.id !== "END_DATE" && element.id !== "departmentInput" && element.id !== "TITLE" && element.id !== "TITLE_DESC") {
                element.readOnly = true;
            } 
        });

        // $("#voteSubmit").hide();
        $(".deleteBtn").hide();
        
        // $(".submitBtn").hide();
        // $(".departmentBtn").hide();
    } 

    $('.departmentBtn').click(function(e) {

        e.preventDefault();

        deptCode = document.getElementById("USE_GROUP_CODE").getAttribute('data-info');
        
        $('#allDepartments option').each(function() {
            var deptname = $(this).data('deptname');
            var deptvalue = $(this).val();

            if (deptCode.includes(deptvalue)) {                
                var optionToAdd = '<option value="' + deptvalue + '" data-deptname="' + deptname + '">' + deptname + '</option>';
                $('#selectedDepartments').append(optionToAdd);
                $(this).remove();
            } 
        });
    });

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