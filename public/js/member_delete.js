
// function getSelectedRowsIds() {
//     var selectedRows = $('#table').bootstrapTable('getSelections');
//     var selectedIds = $.map(selectedRows, function (row) {
//         return $(row.USER_ID).text();
//     });
//     return selectedIds.join(',');
//     // $('#deleteIds').val(selectedIds.join(','));
// }

// $(document).ready(function() {
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     $('#deleteForm').submit(function (event) {
//         event.preventDefault(); 
//         // getSelectedRowsIds();
//         // $(this).unbind('submit').submit();
//         var selectedIds = getSelectedRowsIds();

//         console.log("bulkDestroyUrl",bulkDestroyUrl);

//         // 使用 AJAX 發送 DELETE 請求
//         $.ajax({
//             url: bulkDestroyUrl,
//             type: 'DELETE',
//             data: { ids: selectedIds },
//             success: function (response) {
//                 alert("成功刪除");
//             },
//             error: function (xhr) {
//                 alert("失敗");
//             }
//         });
//     });
// });
