<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\transfer\models\StatementTransfer */
/* @var $transferMpgu \modules\transfer\models\TransferMpgu */
/* @var $job \modules\dictionary\models\JobEntrant */
$job = Yii::$app->user->identity->jobEntrant();
?>
<?php if ($model) :
    $transferMpgu = $model->transferMpgu;
    ?>
    <?php Box::begin(
        [
            "header" => "Заявление",
            "type" => Box::TYPE_SUCCESS,
            "icon" => 'passport',
            "filled" => true,]) ?>
                <?= Html::a('Скачать заявление', ['statement/pdf', 'id' =>  $model->id], ['class' => 'btn btn-warning'])?>
    <?= $model->statusNewViewJob() && $model->isAllFilesAccepted() ?
    Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
        ['statement/status', 'id' => $model->id, 'status'=>StatementHelper::STATUS_ACCEPTED],
        ['data-method' => 'post', 'class' => 'btn btn-success']) : '';  ?>
    <?=  $model->statusNewViewJob() ? Html::a("Отклонить", ["statement/message",  'id' => $model->id], ["class" => "btn btn-danger",
    'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения заявления']) :"" ?>
    <?= $model->statusNoAccepted() ? Html::a('Возврат', ['statement/status', 'id' => $model->id, 'status'=>StatementHelper::STATUS_WALT],
    ['class' => 'btn btn-success']) : "" ?>
    <?= $model->statusNewJob() ? Html::a('Взять в работу', ['statement/status-view', 'id' => $model->id],
    ['class' => 'btn btn-info', 'data' =>["confirm" => "Вы уверены, что хотите взять заявление в работу?"]]) : "" ?>
    <span class="label label-<?= StatementHelper::colorName($model->status)?>">
                        <?=$model->statusNameJob?></span>
                <h4>Куда осуществляется перевод/восстановление?</h4>
                    <?php
                    $columns = [
                        ['label' => '',
                            'value' => $model->cg ? $model->cg->yearConverter()[1]."".$model->cg->getFullNameCg() : "",],
                        ['label' =>'',
                            'value' =>  $model->dictClass ? $model->dictClass->classFullName :"",],
                        ['label' => "Тип",
                            'value' =>  $model->transferMpgu->typeNameShort],
                        ['label' =>$model->getAttributeLabel('finance'),
                        'value' =>  $model->typeFinance]
                    ]; ?>
                    <?= DetailView::widget([
                        'options' => ['class' => 'table table-bordered detail-view'],
                        'model' => $model,
                        'attributes' => $columns
                    ]) ?>
    <?= $this->render('index-exam-backend',['model'=> $model, 'job' => $job ])?>
    <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $model->id, 'model' =>  $model::className(), 'userId' => $model->user_id]) ?>
    <?php Box::end() ?>
<?php endif; ?>

