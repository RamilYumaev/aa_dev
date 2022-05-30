<?php
use yii\helpers\Html;
?>
<div class="form-group required">
     <?= Html::label('Pressed digit', 'pressed_digit', ['class' => 'control-label']) ?>
     <?= Html::textInput('pressed_digit', null, ['id' => 'filter-education_level_id', 'required' => true,  'class' => 'form-control']) ?>
</div>
<br/>