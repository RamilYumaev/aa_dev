<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AddressForm */
$this->title = "Адреса. Добавление.";

$this->params['breadcrumbs'][] =  !Yii::$app->request->get('referrer') ?
    ['label' => 'Персональная карточка поступающего', 'url' => ['/abiturient/default/index']] : ['label' => 'Персональная карточка', 'url' => ['/transfer/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

