<?php

/* @var $this yii\web\View
 * @var $model modules\management\forms\ScheduleForm
 * @var $schedule modules\management\models\Schedule
 */

$this->title = 'Личный график работы';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', ['model'=> $model] )?>
