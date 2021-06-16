<?php
/* @var $cg \dictionary\models\DictCompetitiveGroup*/
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin();
$result = date("Y") - $cg->yearConverter()[1];
$data = array_slice(\dictionary\helpers\DictClassHelper::getListTransfer($cg->edu_level), 0, $result+1); ?>
<div>
    <h4><?= $cg->yearConverter()[1]."".$cg->getFullNameCg()?></h4>

    <label>Курс</label>
    <?= Html::dropDownList('course', '', $data,['class'=> 'form-control']) ?>
</div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>