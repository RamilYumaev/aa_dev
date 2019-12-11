<?php
\frontend\assets\CountdownAsset::register($this);
$script = <<< JS
   $('#clock').countdown('2019/12/11 23:59:59', function(event) {
  $(this).html(event.strftime('%H:%M:%S'));
}).on('finish.countdown', function(event) {
     alert("Ваше время истекло")
  });
JS;
$this->registerJs($script);
?>


<span id="clock"></span>