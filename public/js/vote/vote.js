$(function() {

    $(document).ready(function() {

        const voteDetails = document.getElementById('voteDetails');
        let voteCount = $('.vote-info').length + 1;
    
        $(document).on('click', '#voteSubmit', function(event) {
            event.preventDefault();
    
            const newDiv = document.createElement('div');
            newDiv.classList.add(`VOTE_INFO${voteCount}`);

            newDiv.innerHTML = `
                            <div class="row g-4 mb-6 vote-info">
                                <div class="card">
                                    <h5 class="card-header">序號${voteCount}</h5>
                                    <div class="card-body">
                                        <label for="TITLE" class="form-label">內容</label>
                                        <input class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE]" required>
                                        <div class="col-sm-11">
                                            <label for="TITLE_DESC" class="form-label">描述</label>
                                            <textarea class="form-control" name="VOTE_INFO[${voteCount-1}][TITLE_DESC]" required></textarea>
                                        </div>
                                        <button type="button" class="btn btn-danger deleteBtn">刪除</button>
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
        });

        function updateVoteID(){
            const voteDetails = document.getElementById('voteDetails');
            const voteInfos = voteDetails.querySelectorAll('.vote-info');

            voteInfos.forEach((voteInfo, index) => {
                const serialNumber = voteInfo.querySelector('.card-header');
                const titleInput = voteInfo.querySelector('input[name^="VOTE_INFO["][name$="][TITLE]"]');
                const titleDescInput = voteInfo.querySelector('textarea[name^="VOTE_INFO["][name$="][TITLE_DESC]"]');

                console.log("voteInfo",voteInfo);
                console.log("titleDescInput",titleDescInput);

                if (serialNumber) {
                    serialNumber.textContent = `序號${index + 1}`;
                    titleInput.setAttribute('name', `VOTE_INFO[${index}][TITLE]`);
                    titleDescInput.setAttribute('name', `VOTE_INFO[${index}][TITLE_DESC]`);
                }
            });
        }
    });
});