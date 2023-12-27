function show(){   
    var info = JSON.parse(document.getElementById('vote_info').getAttribute('data-info'));
    var result = document.getElementById('vote_results').getAttribute('data-info');

    var voteDetails = document.getElementById('voteDetails');
    
    let voteCount = 1;
    let count;

    info.forEach(item => {

        const newDiv = document.createElement('div');
        newDiv.classList.add(`vote_info${voteCount}`);
        newDiv.innerHTML = `
            <div class="row g-4 mb-6 vote-info">
                <div class="card">
                    <h5 class="card-header">序號${voteCount}</h5>
                    <div class="card-body">
                        <h5 class="card-title">${item['VOTE_TITLE']}</h5>
                        <p class="card-text">${item['VOTE_TITLE_DESC']}</p>
                    </div>
                </div>
            </div>
        `;
        
        // result頁面
        if (result) {
        
            var voteResults = JSON.parse(result);
            count = voteResults[voteCount-1]['COUNT'];
            console.log("count", count);

            const countElement = document.createElement('p');
            countElement.classList.add('card-text', 'fw-bold', 'text-danger');
            countElement.textContent = `最終票數：${count}`;
            newDiv.querySelector('.card-body').appendChild(countElement);
        } 
        // edit頁面
        else {            
            const voteInput = document.createElement('input');
            voteInput.type = 'radio';
            voteInput.name = 'voteOptions'; 
            voteInput.value = `option${voteCount}`; 
            voteInput.id = `option${voteCount}`; 

            const voteLabel = document.createElement('label');
            voteLabel.classList.add('form-check-label', 'fw-bold', 'text-danger');
            voteLabel.textContent = '投票';

            newDiv.querySelector('.card-body').appendChild(voteInput);
            newDiv.querySelector('.card-body').appendChild(voteLabel);
            
            var VOTE_LINE_NO = document.getElementById('VOTE_LINE_NO').getAttribute('data-info');

            window.addEventListener('load', (event) => {
                const radioButtons = document.querySelectorAll('input[name="voteOptions"]');

                if (VOTE_LINE_NO) {
                    radioButtons.forEach(radio => {
                        if (radio.value === `option${VOTE_LINE_NO}`) {
                            radio.checked = true;
                        } 
                        else {
                            radio.disabled = true;
                        }
                    });
                }
            });
        }
    
        voteDetails.appendChild(newDiv);
        voteCount++;
    });    
}

$(function() {
    show();
    
    window.addEventListener('load', (event) => {
        const disabledOption = document.querySelectorAll('input[name="voteOptions"]:disabled');

        if (disabledOption.length > 0){
            const voteButton = document.getElementById('voteButton');
            voteButton.style = "display:none";
        }
    });
})