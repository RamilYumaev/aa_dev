<?php
use yii\helpers\Html;
use modules\entrant\helpers\DocumentEducationHelper;
use modules\entrant\helpers\OtherDocumentHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12">
        <div class="p-30 green-border">
        <h4>Прочие документы</h4>
        <?= Html::a('Добавить', ['other-document/create'], ['class' => 'btn btn-success']) ?>
            <?php if(DocumentEducationHelper::isNameSurname(Yii::$app->user->identity->getId())): ?>
                <?php if(!OtherDocumentHelper::isExitsUpdateName(Yii::$app->user->identity->getId())): ?>
                    <p class="bg-danger m-10">
                        Необходимо добавить документ, подтверждающий смену фамилии
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'type', 'value' =>'typeName'],
                ['value'=> 'otherDocumentFull', 'header' =>  "Данные"],
                ['value'=> 'noteOrTypeNote', 'header' =>  "Примечание"],
                ['class'=> \yii\grid\ActionColumn::class, 'controller' => 'other-document', 'template'=> '{update}{delete}']
            ],
        ]) ?>
        </div>
    </div>
</div>
