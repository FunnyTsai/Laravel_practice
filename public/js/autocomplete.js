var attribute1_array = [];

function common(elemetId, sqlColumn, inputId) {

  let autoData = document.getElementById(`${elemetId}`).getAttribute('data-auto');
  let autoObject = JSON.parse(autoData);
  let autoArray = [];

  for(let i = 0; i < autoObject.length; i++ ){
    if(autoObject[i][sqlColumn] != null && autoObject[i][sqlColumn] != ''){
      if (typeof(autoObject[i][sqlColumn]) != 'string') {
        autoArray.push(String(autoObject[i][sqlColumn]))
      } 
      else {
        autoArray.push(autoObject[i][sqlColumn])
      }
    }
  }

  console.log(autoArray);

  $(`#${inputId}`).autocomplete({
    source: autoArray
  });
}

console.log();

$(document).on('keydown', '#team', function(e) {
  common('teamAuto', 'TEAM', 'team');
})

$(document).on('keydown', '#user_boss', function(e) {
  common('bossAuto', 'BOSS', 'user_boss');
})

$(document).on('keydown', '#orig_vendor', function(e) {
  common('facAuto', 'Fac', 'orig_vendor');
})

$(document).on('keydown', '#attribute1', function(e) {
  common('attribute1Auto', 'USER_INFO', 'attribute1');
})

// $(document).on('change', '#attribute1', function(e) {
//   var attribute1_array = (document.getElementById('attribute1').value).split(' ');
//   var attribute1_id = attribute1_array[0];
//   var attribute1_namearray = attribute1_array.slice(1,);
//   document.getElementById('attribute1_name').value = attribute1_namearray.join(' ');
// })

// 新增的時候把原廠的英文存入#fac_auto的value中
// fac_auto_value = (document.getElementById('orig_vendor').value).split(' ')[0];

$(function() {
});
