<?php
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $olympic olympic\models\OlimpicList */
/* @var $model olympic\forms\OlimpicListEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = 'Обновить';
\backend\assets\olympic\OlympicEditAsset::register($this);
?>
<div>
    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
    <?= $this->render('_form', ['form'=>$form, 'model' => $model, 'olympic_id' =>$olympic->olimpic_id])?>
    <?php ActiveForm::end(); ?>
</div>
