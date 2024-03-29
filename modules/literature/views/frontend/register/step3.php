<?php
use yii\helpers\Html;
$validate = $model->validate();
$model->clearErrors();
?>
<?= $this->render('steps',['step'=>$step,'isRoute' => $isRoute]) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-20">
            <?=  Html::a("<< Шаг 2", ['step2'], ['class'=>'btn btn-warning pull-left'])?>
            <?= $validate ? Html::a("Шаг 4 >>", ['step4'], ['class'=>'btn btn-primary pull-right']) :""?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-20">
            <?= $this->render('form/_form_olympic_2', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>

