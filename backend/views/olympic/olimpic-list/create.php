<?php
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $olympic olympic\models\OlimpicList */
/* @var $model olympic\forms\OlimpicListCreateForm*/
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\olympic\OlympicCreateAsset::register($this);
?>
<div>
    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
    <?= $this->render('_form', ['form'=>$form, 'model' => $model, 'olympic_id'=> $model->olimpic_id ])?>
    <?php ActiveForm::end(); ?>
</div>