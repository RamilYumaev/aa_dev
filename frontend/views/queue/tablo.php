<?php
/** @var $queues array */
$this->title = "Электронная очередь";
use yii\helpers\Html;
use yii\widgets\Pjax; ?>
<?php
$script = <<<JS
$(document).ready(function() {
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

    setInterval(function(){
        location.reload();
    }, 5000);
});
JS;
$this->registerJs($script);
?>
<?php Pjax::begin(); ?>
<style type="text/css" scoped>
    @font-face{font-family:'VAG World';src:url("VAG World Bold.ttf");font-weight:700;font-style:normal;font-stretch:normal;unicode-range:U+0020-00FE}.header_talons{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;font-family:'Roboto', sans-serif;font-size:40px;margin:0px 0 5px 0}.header_talons div{width:900px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:0 83px 0 34px}.header_talons div:nth-child(2){margin-right:30px}.talons{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-ms-flex-wrap:wrap;flex-wrap:wrap;justify-items:center;height:960px;margin:5px;margin-left:10px}.talon{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-pack:distribute;justify-content:space-around;width:940px;padding:45px 10px}.bgBlue{background:rgba(30,158,230,0.19)}.img{width:64px;height:64px;margin:25px 0 0 40px}.person{font-family:'VAG World', 'Roboto', sans-serif;line-height:85px;color:#3F88C5;text-align:center;font-size:57px}.table{width:30%;font-family:'VAG World', 'Roboto', sans-serif;line-height:85px;color:#4F4F4F;text-align:center;font-size:80px}.header{padding:0px 60px 0 60px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;color:#272727}.header .title{font-family:VAG World;font-style:normal;font-weight:bold;font-size:50px;line-height:77px;color:#3F88C5}.logo{height:70px}.date-wraper{font-family:'VAG World', 'Roboto', sans-serif;font-size:50px;line-height:98px;width:485px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.annotation{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.annotation-item{display:inline;margin-right:36px;padding:37px 0;position:relative}.annotation-item:nth-child(3){margin-right:0}.annotation-arrow{position:absolute;display:inline-block;top:27px}.annotation-text{display:inline-block;font-weight:normal;font-size:36px;line-height:42px;margin-left:70px}*{font-family:'Roboto', sans-serif;margin:0;padding:0;-webkit-box-sizing:border-box;box-sizing:border-box}.table-class{width:50px}.version{font-size:27px}
</style>
<div id="queue">

<div class="header">
    <!-- <img src="../assets/logo.png" alt="logo" class="logo" /> -->
    <div class="annotation">
      <div class="annotation-item">
        <div class="annotation-arrow">
          <img src="assets/1.png" alt="new">
        </div>
        <div class="annotation-text">
          Новый
        </div>
      </div>
      <div class="annotation-item">
        <div class="annotation-arrow">
          <img src="assets/2.png" alt=repeat">
        </div>
        <div class="annotation-text">
          Повторный
        </div>
      </div>
      <div class="annotation-item">
        <div class="annotation-arrow">
          <img src="assets/0.png" alt="old">
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
<div id="contacts_list" class="talons">
<?php foreach ($queues as $key => $queue)  : ?>
        <div class='talon' >
        <div class='person'>
        <?= $queue['talon'] ?>
        </div>
        <div class='table'>
        <?= $queue['number_of_table'] ?>
        </div>
    </div>
            
        <?php endforeach; ?></tbody>
    
</div>
<?php Pjax::end(); ?>
