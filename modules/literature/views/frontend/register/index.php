<?php
use yii\helpers\Html;
?>
<?= $this->render('steps',['step'=>$step, 'isRoute' => $isRoute]) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?=  Html::a("Шаг 2", ['step2'], ['class'=>'btn btn-primary pull-right'])?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-20">
            <?= $this->render('form/_form_user', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>

