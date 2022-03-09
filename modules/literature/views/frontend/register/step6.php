<?php
$this->params['breadcrumbs'][] = ['label' => 'Всероссийская олимпиада школьников по литературе', 'url' => 'default/index'];

use yii\helpers\Html; ?>
<?= $this->render('steps',['step'=>$step]) ?>
<div class="container">
    <div class="col-md-12">
        <?=  Html::a("Шаг 5", ['step5'], ['class'=>'btn btn-warning pull-left']) ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('form/_form_olympic_4', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>

