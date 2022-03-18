<?php
use yii\helpers\Html;
$validate = $model->validate();
$model->clearErrors();
?>
<?= $this->render('steps',['step'=>$step, 'isRoute' => $isRoute]) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-20">
            <?=  Html::a("<< Шаг 3", ['step3'], ['class'=>'btn btn-warning pull-left'])?>
            <?= $validate ? Html::a("Шаг 5 >>", ['step5'], ['class'=>'btn btn-primary pull-right']) :""?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-20">
            <?= $this->render('form/_form_olympic_3', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>

