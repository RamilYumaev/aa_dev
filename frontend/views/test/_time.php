<?php
$date = date("Y-m-d H:i:s");
$script = <<<JS
function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
var today=new Date('$date');
var future=new Date('$time');
function setTime() {
    var newTotalSecsLeft;
    newTotalSecsLeft  = future.getTime() - today.getTime(); // Millisecs
    newTotalSecsLeft = Math.ceil(newTotalSecsLeft / 1000); // Secs
     var totalSecsLeft = newTotalSecsLeft;
     var elapsed = (today >= future); 
     if (totalSecsLeft == 0) {  
         $("#clock").html("00:00:00");
          alert("Время вышло");
          $.post( "$url");
          return;
     }
    today.setSeconds(today.getSeconds()+1);
    offset = {
        seconds     : totalSecsLeft % 60,
        minutes     : Math.floor(totalSecsLeft / 60) % 60,
        hours       : Math.floor(totalSecsLeft / 60 / 60) % 24,
      };
    hour = checkTime(offset.hours);
    minute = checkTime(offset.minutes);
    second = checkTime(offset.seconds);
    var timeу = hour+":"+minute+":"+second;
    $("#clock").html(timeу);
    return timeу;
} 
setInterval(setTime, 1000);
$("#clock").html(setTime());
JS;
$this->registerJs($script);
?>
<span id="clock"></span>