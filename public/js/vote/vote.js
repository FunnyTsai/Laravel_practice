$(function() {
    const voteDetails = document.getElementById('voteDetails');
    let voteCount = $('.vote-info').length + 1;

    $(document).on('click', '#voteSubmit', function(event) {
        event.preventDefault();

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
                                    <input class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE]" required>
                                    <div class="col-sm-11">
                                        <label for="TITLE_DESC" class="form-label">描述</label>
                                        <textarea class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE_DESC]" required></textarea>
                                    </div>
                                </div>
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
    
        // 檢查是否還有其他 .vote-info1 元素存在，如果沒有 .vote-info 子元素，則刪除它
        $('.vote_info1').each(function() {
            if ($(this).find('.vote-info').length === 0) {
                $(this).remove();
            }
        });
    });

    function updateVoteID(){
        const voteDetails = document.getElementById('voteDetails');
        const voteInfos = voteDetails.querySelectorAll('.vote-info');

        voteInfos.forEach((voteInfo, index) => {
            const serialNumber = voteInfo.querySelector('span');
            const titleInput = voteInfo.querySelector('input[name^="VOTE_INFO["][name$="][TITLE]"]');
            const titleDescInput = voteInfo.querySelector('textarea[name^="VOTE_INFO["][name$="][TITLE_DESC]"]');

            // console.log("index",index);
            // console.log("voteInfo",voteInfo);
            // console.log("titleDescInput",titleDescInput);

            if (serialNumber) {
                serialNumber.textContent = `選項${index + 1}`;
                titleInput.setAttribute('name', `VOTE_INFO[${index}][TITLE]`);
                titleDescInput.setAttribute('name', `VOTE_INFO[${index}][TITLE_DESC]`);
            }
        });
    }

    document.getElementById('voteForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // -----防呆：檢查部門是否為空-----
        var textarea = document.getElementById('departmentInput');
        var textareaContent = textarea.value.trim();

        if (textareaContent === '') {
            alert('部門不得為空！'); 
            textarea.focus();
            return;
        }
        
        // -----防呆：檢查投票明細是否為空-----
        var voteDetailsExist = document.querySelectorAll('.vote_info1').length > 0;

        console.log("voteDetailsExist",voteDetailsExist);

        if (voteDetailsExist == false) {
            alert('投票明細不得為空！'); 
            $("#voteDetails").focus();
            return;
        } 
        
        // -----防呆：投票開始日期必須小於投票結束日期-----
        var START_DATE = document.getElementById("START_DATE").value;
        var END_DATE = document.getElementById("END_DATE").value;

        if (START_DATE >= END_DATE) {
            alert('投票開始日期不得大於投票結束日期！'); 
            $("#START_DATE").focus();
            return;
        }         
        
        event.target.submit();
    });    
});