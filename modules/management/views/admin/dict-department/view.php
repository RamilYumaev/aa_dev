<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $model modules\management\models\DictDepartment */
/* @var  $postRateDepartment modules\management\models\PostRateDepartment */
/* @var $managementUser modules\management\models\ManagementUser */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Отделы УОПП', 'url' => ['dict-department/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php foreach ($model->getPostRateDepartment()->all() as $postRateDepartment): ?>
    <div class="box">
        <div class="box-header">
            <?= $postRateDepartment->postManagement->name?> \ <?= $postRateDepartment->rateName?>
        </div>
        <?php if($postRateDepartment->getManagementUser()->count()) : ?>
        <div class="box-body">
            <table class="table">
                <tr>
                    <th>ФИО</th>
                    <?php if(!$postRateDepartment->postManagement->is_director): ?>
                    <th>Помощник?</th>
                    <th>#</th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($postRateDepartment->getManagementUser()->all() as $managementUser): ?>
                <tr>
                    <td><?= $managementUser->profile->fio ?></td>
                    <?php if(!$postRateDepartment->postManagement->is_director): ?>
                    <td><?= $managementUser->is_assistant ? 'Да' : 'Нет'?></td>
                    <td><?= Html::a($managementUser->is_assistant ? "Снять" : 'Назначить', [ 'management-user/assistant','userId'=> $managementUser->user_id,
                            'postRateId'=> $managementUser->post_rate_id, 'assistant'=> $managementUser->is_assistant ? false : true  ],
                            ['class' => $managementUser->is_assistant ? 'btn btn-danger' :  'btn btn-success' ])?></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>