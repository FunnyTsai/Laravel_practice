function common(elemetId, sqlColumn, inputId) {

  let autoData = document.getElementById(`${elemetId}`).getAttribute('data-auto');
  let autoObject = JSON.parse(autoData);
  let autoArray = [];

  for(let i = 0; i < autoObject.length; i++ ){
    if(autoObject[i][sqlColumn] != null && autoObject[i][sqlColumn] != ''){
      autoArray.push(autoObject[i][sqlColumn])
    }
  }

  $(`#${inputId}`).autocomplete({
    source: autoArray
  });
}

$(document).on('keydown', '#team', function(e) {
  common('teamAuto', 'TEAM', 'team');
})

$(document).on('keydown', '#user_boss', function(e) {
  common('bossAuto', 'USER_NAME', 'user_boss');
})

$(document).on('keydown', '#orig_vendor', function(e) {
  common('fac_auto', 'Fac', 'orig_vendor');
})

// 新增的時候把原廠的英文存入#fac_auto的value中
// fac_auto_value = (document.getElementById('orig_vendor').value).split(' ')[0];

$(function() {
});
