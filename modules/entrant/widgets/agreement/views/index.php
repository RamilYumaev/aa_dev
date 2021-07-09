<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\Agreement */
?>
<?php if ($model) : ?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model && $model->date ?? false) ?>">
        <div class="p-30 green-border">
            <h4>Договор о целевом обучении</h4>
            <?= Html::a('Редактировать', ['agreement/index'], ['class' => 'btn btn-primary']) ?>
            <?php if ($swichUserId = \Yii::$app->session->get('user.idbeforeswitch')) : ?>
            <?php if (Yii::$app->authManager->getAssignment('dev', $swichUserId)): ?>
            <?= Html::a('Удалить', ['agreement/delete'], ['class' => 'btn btn-danger', 'data-confirm' => 'Вы уверены, что хотите удалить договор?']) ?>
            <?php endif; ?>
            <?php endif; ?>
            <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                        ['label'=> 'Заказчик', 'value'=> $model->organization ? $model->fullOrganization : ''],
                    ['label'=> 'Работодатель', 'value'=> $model->organizationWork ? $model->fullOrganizationWork : ''],
                    'number',
                    'date:date',
                ]
            ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>