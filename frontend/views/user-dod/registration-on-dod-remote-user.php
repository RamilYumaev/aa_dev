<?php

/* @var $this yii\web\View */
/* @var $dod dod\models\DateDod */
/* @var $model dod\forms\SignupDodForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
\common\user\assets\AddSchoolAsset::register($this);

$this->title = "Регистрация на ". $dod->dodOne->name;
$this->params['breadcrumbs'][] = ['label' => 'Дни открытых дверей', 'url' => ['/dod']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><i><?= $dod->dateStartString ?></i></p>
    <p><i><?= $dod->timeStartString ?></i></p>
    <p><?= $dod->dodOne->addressString ?></p>
    <p><?= $dod->dodOne->audNumberString ?></p>
    <?= $dod->textString ?>
    <h4>Заполните следующую форму:</h4>
    <?= $this->render('_form', ['model' => $model, 'dod' => $dod]) ?>

</div>