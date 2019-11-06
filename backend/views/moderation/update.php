<?php
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
$array = \yii\helpers\Json::decode($model->before);
$array = array_flip($array);
?>
<div class="faculty-update">
    <div class="box box-default">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model->model::findOne($model->record_id),
                'attributes' => array_values($array)
            ]) ?>
        </div>
    </div>
     <?= Yii::$app->view->renderFile('@backend/views/dictionary/faculty/update_moderation.php',
         ['model'=>  new \dictionary\forms\FacultyEditForm($modes)])?>

</div>
