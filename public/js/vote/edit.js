function show(){   
    var info = JSON.parse(document.getElementById('vote_info').getAttribute('data-info'));

    var voteDetails = document.getElementById('voteDetails');
    
    let voteCount = 0;

    console.log("info",info);
    console.log("voteDetails",voteDetails);

    info.forEach(function(item) {

        voteCount++;
        
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
                    <input class="form-control" name="TITLE" value="${item['VOTE_TITLE']}" required>
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-11">
                    <label for="TITLE_DESC" class="form-label">描述</label>
                    <textarea class="form-control" name="TITLE_DESC" required>${item['VOTE_TITLE_DESC']}</textarea>
                </div>
            </div>
        `;

        voteDetails.appendChild(newDiv); 
    });
}

$(function() {
    show();
})