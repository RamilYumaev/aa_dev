<?php
use yii\helpers\Html; ?>
<?= $this->render('steps',['step'=>$step]) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?=  Html::a("Шаг 2", ['step2'], ['class'=>'btn btn-warning pull-left'])?>
            <?=  Html::a("Шаг 4", ['step4'], ['class'=>'btn btn-primary pull-right'])?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('form/_form_olympic_2', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>

