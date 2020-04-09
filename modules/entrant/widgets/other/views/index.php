<?php
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;
use modules\entrant\helpers\OtherDocumentHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Прочие документы</h4>
        <?= Html::a('Добавить', ['other-document/create'], ['class' => 'btn btn-success']) ?>
        <?php if(UserCgHelper::userMedicine(Yii::$app->user->identity->getId())): ?>
            <?php if(!OtherDocumentHelper::isExitsMedicine(Yii::$app->user->identity->getId())): ?>
                <p class="bg-danger m-10">
                     Необходимо добавить медицинскую справку 086-у
                </p>
            <?php endif; ?>
        <?php endif; ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'type', 'value' =>'typeName'],
                ['value'=> 'otherDocumentFull', 'header' =>  "Данные"],
                ['class'=> \yii\grid\ActionColumn::class, 'controller' => 'other-document', 'template'=> '{update}{delete}']
            ],
        ]) ?>
    </div>
</div>
