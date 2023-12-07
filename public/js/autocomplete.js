
// 寫一個共用function直接呼叫

$(function() {
  // let bossAutoData = document.getElementById('bossAuto').getAttribute('data-auto');
  // let bossAutoObject = JSON.parse(bossAutoData);
  // let autoArray = [];

  // for(let i = 0; i < bossAutoObject.length; i++ ){
  //   autoArray.push(bossAutoObject[i]['USER_NAME'])
  // }
          
  // $( "#user_boss" ).autocomplete({
  //   source: autoArray
  // });

  let teamAutoData = document.getElementById('teamAuto').getAttribute('data-auto');
  let teamAutoObject = JSON.parse(teamAutoData);
  let autoArray = [];


  for(let i = 0; i < teamAutoObject.length; i++ ){
    if(teamAutoObject[i]['TEAM'] != null && teamAutoObject[i]['TEAM'] != ''){
      autoArray.push(teamAutoObject[i]['TEAM'])
    }
  }
          
  $("#team").autocomplete({
    source: autoArray
  });
});
