$(document).ready(function() {
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
});