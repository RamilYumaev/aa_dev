<?php
$this->title = "Электронная очередь";

use yii\helpers\Html;
use yii\widgets\Pjax; ?>
<?php
$script = <<<JS
$(document).ready(function() {
    function  chooseColor (status) {
      if (status === 0) {
       return '#1E9EE6';
      } else if (status === 1) {
        return '#27AE60';
      } else {
          return '#EB5757';
      }
    }
    var queue = $('#queue');
      queue.hide();
    setInterval(function(){
        queue.show(1000);
        $.ajax({
  url: '/queue/json',
  success: function(data){
      var tbody = $('table > tbody');
         tbody.empty();
        for(var i = 0; i < data.length; ++i) {
         tbody.append('<tr>');
         tbody.append($("<td></td>").css({'color': chooseColor(data[i].status)}).text(data[i].talon));
         tbody.append($("<td></td>").text(data[i].number_of_table));
         tbody.append('</tr>');
         }
  }
});
    }, 1000);
});
JS;
$this->registerJs($script);
?>
<div id="queue">
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
</div>
