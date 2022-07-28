<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestResult */
?>
<?= $quent->question->text ?>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::textarea('AnswerAttempt[detailed]', $a['detailed'] ?? "", ['cols'=>105, "rows"=>10, 'id'=> 'detailed', 'maxlength'=>4000]) ?>
    <p>Количество знаков: <span id="count"></span></p>
    <p>Текст должен содержать от 2000 до 4000 знаков.</p>
    <p style="color:red;">Перед сохранением ответа необходмио скопировать текст у себя.</p>
<?php
$script = <<<JS
 const detailed =$("#detailed");

 $('#count').text(detailed.val().length);
 detailed.keyup(function() {
    const count = $(this).val().length;
    $('#count').text(count);
 });
$('form').submit(function(event) {
  if(detailed.val().length < 2000 || detailed.val().length > 4000) {
      alert("Текст может содержать от 2000 до 4000 знаков");
      return false
  }
})
JS;
$this->registerJs($script);

?>