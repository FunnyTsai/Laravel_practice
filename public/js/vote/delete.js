function getSelectedRowsIds() {
    var selectedRows = $('#table').bootstrapTable('getSelections');
    var selectedIds = $.map(selectedRows, function (row) {
        return $(row.VOTE_ID); 
    });
    return selectedIds;
}

$(document).ready(function () {
    $('#deleteForm').submit(function (e) {
        e.preventDefault();
        var selectedIds = getSelectedRowsIds();
        $('#deleteIds').val(selectedIds);
        this.submit();
    });
});