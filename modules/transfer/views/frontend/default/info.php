<?php
/* @var $cg \dictionary\models\DictCompetitiveGroup*/
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(); ?>
<div>
    <label>Образование</label>
    <?= Html::dropDownList('edu_count', '', (new \modules\transfer\models\CurrentEducation())->listEdu(),['class'=> 'form-control']) ?>
</div>
<br/>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>