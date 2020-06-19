<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AdditionalInformationForm */
/* @var $additional modules\entrant\models\AdditionalInformation */
/* @var $anketaMoscow bool */
/* @var $addressMoscow \modules\entrant\models\Address */

$this->title = "Дополнительная информация ". ($additional ? "Редактирование": "Добавление").".";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title; ?>
<?= $this->render('_form', ['model'=> $model, 'anketaMoscow' =>$anketaMoscow, 'addressMoscow' => $addressMoscow] )?>

