<?php
$this->title = "Электронная очередь";

use yii\helpers\Html;
use yii\widgets\Pjax; ?>
<?php
$script = <<<JS
$(document).ready(function () {

// <div class="date-wraper time">{{ hours }}:{{minutes}}</div>
// <div class="date-wraper date">{{ date }}</div>
let hours, minutes, seconds, date, fullDate

function updateTime () {
const Data = new Date()
hours = Data.getHours()
minutes = Data.getMinutes()
seconds = Data.getSeconds()
if (hours < 10) {
  hours = '0' + hours
}
if (minutes < 10) {
  minutes = '0' + minutes
}
date = Data.getDate() + '.' + 0+(Data.getMonth() + 1) + '.' + Data.getFullYear()
fullDate = "<div class='date-wraper time'>"+hours+":"+minutes+"</div> <div class='date-wraper date'>"+date+"</div>"
}
setInterval(function() {
updateTime()
$('#date-wraper').html(fullDate)
},1000)




function toArray(obj) {
  let i = 0
  for (i in obj) {
    if (obj[i] && i < 10) {
      array.push(obj[i])
    }
  }
}

function chooseColor (status) {
      if (status === 0) {
        return '#EB5757'
      } else if (status === 1) {
        return '#1E9EE6'
      } else {
        return '#27AE60'
      }
}
let array = [];

setInterval(function () {
$.getJSON('https://api.sdo.mpgu.org/queue', function (data) {
  array = []
  let array1 = ''
  toArray(data)
  array1 = array.map(function (el, index) {
    let bgBlue = "bgBlue"
    let fSize = 57
    if (index < 5 && index % 2 !== 0) {
      bgBlue = ""
    } else if (index > 4 && index % 2 === 0) {
      bgBlue = ""
    }

    const reg = new RegExp(/[A-Za-zА-Яа-я]{2,}/)
  if (reg.test(el.talon)) {
    fSize = 35
  } 
    

    return "<div class='talon " + bgBlue + "' name='" + el.talon + "'>" +
      "<div class='person' style='font-size: "+fSize+"px'>" +
      JSON.stringify(el.talon).split('"').join('') +
      "</div>" +
      "<div class='arrow'><svg width='37' height='64' viewBox='0 0 37 64' fill='" + 
      chooseColor(el.status) +"' xmlns='http://www.w3.org/2000/svg'><path d='M36.4818 32.0002C36.4818 33.1472 36.0438 34.2941 35.1698 35.1685L7.65094 62.6871C5.9004 64.4376 3.0622 64.4376 1.31237 62.6871C-0.437458 60.9373 -0.437458 58.0996 1.31237 56.349L25.6626 32.0002L1.31322 7.65127C-0.436607 5.90073 -0.436607 3.06338 1.31322 1.31369C3.06306 -0.437698 5.90125 -0.437698 7.65179 1.31369L35.1706 28.8318C36.0448 29.7067 36.4818 30.8536 36.4818 32.0002Z''/></svg></div>" +
      "<div class='table'>" +
      JSON.stringify(el.number_of_table).split('"').join('') +
      "</div>" +
      "</div>";
  })
  $('#contacts_list').html(array1)
});
}, 5000) 
});

// $(document).ready(function() {
  
//     function  chooseColor (status) {
//       if (status === 0) {
//        return '#1E9EE6';
//       } else if (status === 1) {
//         return '#27AE60';
//       } else {
//           return '#EB5757';
//       }
//     }
//     var queue = $('#queue');
//       queue.hide();
//     setInterval(function(){
//         queue.show(1000);
//         $.ajax({
//   url: 'https://api.sdo.mpgu.org/queue',
//   success: function(data){
//       var tbody = $('table > tbody');
//          tbody.empty();
//         for(var i = 0; i < data.length; ++i) {
//          tbody.append('<tr>');
//          tbody.append($("<td></td>").css({'color': chooseColor(data[i].status)}).text(data[i].talon));
//          tbody.append($("<td></td>").text(data[i].number_of_table));
//          tbody.append('</tr>');
//          }
//   }
// });
//     }, 1000);
// });
JS;
$this->registerJs($script);
?>

<style type="text/css" scoped>
    @font-face{font-family:'VAG World';src:url("VAG World Bold.ttf");font-weight:700;font-style:normal;font-stretch:normal;unicode-range:U+0020-00FE}.header_talons{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;font-family:'Roboto', sans-serif;font-size:40px;margin:0px 0 5px 0}.header_talons div{width:900px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:0 83px 0 34px}.header_talons div:nth-child(2){margin-right:30px}.talons{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-ms-flex-wrap:wrap;flex-wrap:wrap;justify-items:center;height:960px;margin:5px;margin-left:10px}.talon{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-pack:distribute;justify-content:space-around;width:940px;padding:45px 10px}.bgBlue{background:rgba(30,158,230,0.19)}.img{width:64px;height:64px;margin:25px 0 0 40px}.person{font-family:'VAG World', 'Roboto', sans-serif;line-height:85px;color:#3F88C5;text-align:center;font-size:57px}.table{width:30%;font-family:'VAG World', 'Roboto', sans-serif;line-height:85px;color:#4F4F4F;text-align:center;font-size:80px}.header{padding:0px 60px 0 60px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;color:#272727}.header .title{font-family:VAG World;font-style:normal;font-weight:bold;font-size:50px;line-height:77px;color:#3F88C5}.logo{height:70px}.date-wraper{font-family:'VAG World', 'Roboto', sans-serif;font-size:50px;line-height:98px;width:485px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.annotation{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.annotation-item{display:inline;margin-right:36px;padding:37px 0;position:relative}.annotation-item:nth-child(3){margin-right:0}.annotation-arrow{position:absolute;display:inline-block;top:27px}.annotation-text{display:inline-block;font-weight:normal;font-size:36px;line-height:42px;margin-left:70px}*{font-family:'Roboto', sans-serif;margin:0;padding:0;-webkit-box-sizing:border-box;box-sizing:border-box}.table-class{width:50px}.version{font-size:27px}
</style>

<div class="version">Версия 1.3</div>
  <div class="header">
    <!-- <img src="../assets/logo.png" alt="logo" class="logo" /> -->
    <div class="annotation">
      <div class="annotation-item">
        <div class="annotation-arrow">
              <svg width="37" height="64" viewBox="0 0 37 64" fill="#EB5757" xmlns="http://www.w3.org/2000/svg">
              <path d="M36.4818 32.0002C36.4818 33.1472 36.0438 34.2941 35.1698 35.1685L7.65094 62.6871C5.9004 64.4376 3.0622 64.4376 1.31237 62.6871C-0.437458 60.9373 -0.437458 58.0996 1.31237 56.349L25.6626 32.0002L1.31322 7.65127C-0.436607 5.90073 -0.436607 3.06338 1.31322 1.31369C3.06306 -0.437698 5.90125 -0.437698 7.65179 1.31369L35.1706 28.8318C36.0448 29.7067 36.4818 30.8536 36.4818 32.0002Z"/>
              </svg>
        </div>
        <div class="annotation-text">
          Новый
        </div>
      </div>
      <div class="annotation-item">
        <div class="annotation-arrow">
        <svg width="37" height="64" viewBox="0 0 37 64" fill="#1E9EE6" xmlns="http://www.w3.org/2000/svg">
              <path d="M36.4818 32.0002C36.4818 33.1472 36.0438 34.2941 35.1698 35.1685L7.65094 62.6871C5.9004 64.4376 3.0622 64.4376 1.31237 62.6871C-0.437458 60.9373 -0.437458 58.0996 1.31237 56.349L25.6626 32.0002L1.31322 7.65127C-0.436607 5.90073 -0.436607 3.06338 1.31322 1.31369C3.06306 -0.437698 5.90125 -0.437698 7.65179 1.31369L35.1706 28.8318C36.0448 29.7067 36.4818 30.8536 36.4818 32.0002Z"/>
              </svg>
        </div>
        <div class="annotation-text">
          Повторный
        </div>
      </div>
      <div class="annotation-item">
        <div class="annotation-arrow">
        <svg width="37" height="64" viewBox="0 0 37 64" fill="#27AE60" xmlns="http://www.w3.org/2000/svg">
              <path d="M36.4818 32.0002C36.4818 33.1472 36.0438 34.2941 35.1698 35.1685L7.65094 62.6871C5.9004 64.4376 3.0622 64.4376 1.31237 62.6871C-0.437458 60.9373 -0.437458 58.0996 1.31237 56.349L25.6626 32.0002L1.31322 7.65127C-0.436607 5.90073 -0.436607 3.06338 1.31322 1.31369C3.06306 -0.437698 5.90125 -0.437698 7.65179 1.31369L35.1706 28.8318C36.0448 29.7067 36.4818 30.8536 36.4818 32.0002Z"/>
              </svg>
        </div>
        <div class="annotation-text">
          Старый
        </div>
      </div>
    </div>
    <div class="date-wraper" id="date-wraper">
    </div>
  </div>
  <div class="header_talons">
    <div>
      <span>Поступающий</span>
      <span>№ стола</span>
    </div>
    <div>
      <span>Поступающий</span>
      <span>№ стола</span>
    </div>

  </div>
  <div id="contacts_list" class="talons"></div>

<!-- <div id="queue">
<h1> <span style="color: blue">Новый</span> <span style="color:green">Повторный</span> <span style="color:red">Старый</span></h1>
<table>
    <thead>
        <tr>
            <th>Талон</th>
            <th>Стол</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
</div> -->
