<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\models\AisReturnData */
/* @var  $id integer */
?>
<div class="box box-danger">
    <?php if($model): ?>
    <div class="pull-right">
        <div class="box-body" style="margin: 10px">
            <?= \yii\helpers\Html::a('Обновить данные в АИС ВУЗ', ['update-export-data',  'id' => $id,'did' => $model->id], ['class'=> 'btn btn-success', 'data' => [
                    'confirm' => 'Вы уверены, что хотите обновить данные в АИС ВУЗ?',
                    'method' => 'post',
                ]])?>
            <?= \yii\helpers\Html::a('json', ['json',  'id' => $id,  'did' => $model->id], ['class'=> 'btn btn-danger'])?>
        </div>
    </div>
    <?php else: ?>
    <div class="box-body" style="margin: 10px">
        <div class="pull-right">
        <?= \yii\helpers\Html::a('Обновить данные в АИС ВУЗ', ['update-export-data',   'id' => $id], ['class'=> 'btn btn-success', 'data' => [
            'confirm' => 'Вы уверены, что хотите обновить данные в АИС ВУЗ?',
            'method' => 'post',
        ]])?>
        <?= \yii\helpers\Html::a('json', ['json',  'id' => $id], ['class'=> 'btn btn-danger'])?>
        </div>
    </div>
    <?php endif; ?>
</div>



