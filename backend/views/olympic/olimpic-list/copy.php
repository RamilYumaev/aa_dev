<?php

use backend\assets\olympic\OlympicCopyAsset;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $olympic olympic\models\OlimpicList */
/* @var $model olympic\forms\OlimpicListCopyForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Копировать: ';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = 'Копировать';
 OlympicCopyAsset::register($this);
?>
<div>
    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
        <?= $this->render('_form', ['form'=>$form, 'model' => $model, 'olympic_id'=> $olympic->olimpic_id ])?>
    <?php ActiveForm::end(); ?>
</div>
