$(function() {

    // // 按下新增按鈕時新增群組<li>
    // $(document).on('click', '#voteSubmit', function(event) {
    //     event.preventDefault(event);
    
    //     const voteDetails = document.getElementById('voteDetails');
    //     let voteCount = 1; // 初始序號
        
    //     // 創建一個新的 div 元素
    //     const newDiv = document.createElement('div');
    //     newDiv.classList.add(`vote_info${voteCount}`); // 加入特定的 CSS 類別

    //     // 新增 HTML 結構到新的 div 元素
    //     newDiv.innerHTML = `
    //         <div class="row g-4 mb-6 vote-info">
    //             <div class="col-sm-1">
    //                 <button type="button" class="btn btn-danger btn-sm deleteBtn">刪除</button>
    //             </div>
    //             <div class="col-sm-1">
    //                 <label for="TITLE" class="form-label">序號</label>
    //                 <span class="form-control">${voteCount}</span>
    //             </div>
    //             <div class="col-sm-10">
    //                 <label for="TITLE" class="form-label">內容</label>
    //                 <input class="form-control" name="TITLE" required>
    //             </div>
    //             <div class="col-sm-1">
    //             </div>
    //             <div class="col-sm-11">
    //                 <label for="TITLE_DESC" class="form-label">描述</label>
    //                 <textarea class="form-control" name="TITLE_DESC" required></textarea>
    //             </div>
    //         </div>
    //     `;

    //     // 將新的 div 元素加入目標區域
    //     voteDetails.appendChild(newDiv);
    //     voteCount++; // 增加序號
    // });

    // const voteDetails = document.getElementById('voteDetails');

    // // 點擊刪除按鈕時刪除投票明細
    // $(document).on('click', '.deleteBtn', function() {
    //     voteDetails.removeChild(newDiv);
    // });

    $(document).ready(function() {
        const voteDetails = document.getElementById('voteDetails');
        let voteCount = $('.vote-info').length + 1;
    
        // 點擊新增按鈕時新增群組<li>
        $(document).on('click', '#voteSubmit', function(event) {
            event.preventDefault();
    
            const newDiv = document.createElement('div');
            newDiv.classList.add(`vote_info${voteCount}`);
    
            newDiv.innerHTML = `
                <div class="row g-4 mb-6 vote-info">
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-danger btn-sm deleteBtn">刪除</button>
                    </div>
                    <div class="col-sm-1">
                        <label for="TITLE" class="form-label">序號</label>
                        <span class="form-control vote_info_id">${voteCount}</span>
                    </div>
                    <div class="col-sm-10">
                        <label for="TITLE" class="form-label">內容</label>
                        <input class="form-control" name="TITLE" required>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-11">
                        <label for="TITLE_DESC" class="form-label">描述</label>
                        <textarea class="form-control" name="TITLE_DESC" required></textarea>
                    </div>
                </div>
            `;
    
            voteDetails.appendChild(newDiv);            

            updateVoteID();
        });
    
        // 點擊刪除按鈕時刪除對應的 div 元素
        $(document).on('click', '.deleteBtn', function() {
            const parentDiv = this.closest('.vote-info'); 
            parentDiv.remove(); 
            updateVoteID();
        });

        function updateVoteID(){
            $('.vote-info').each(function(index) {
                $(this).find('.vote_info_id').text(index + 1);
            });
        }
    });
});