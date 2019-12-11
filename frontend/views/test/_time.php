<?php
\frontend\assets\CountdownAsset::register($this);


$script = <<< JS
   $('#clock').countdown('$time', function(event) {
  $(this).html(event.strftime('%H:%M:%S'));
}).on('finish.countdown', function(event) {
     alert("Ваше время истекло")
  });
JS;
$this->registerJs($script);
?>


<span id="clock"></span>