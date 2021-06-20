<?php
/**
 * @var $listProfiles
 * @var $profile olympic\models\auth\Profiles
 *  @var $model frontend\search\Profile*/

use yii\helpers\Html; ?>
<div class="p-30 green-border">
    <h4>Данные по ФИО: <?= $model->last_name ?> <?= $model->first_name ?> <?= $model->patronymic ?>  </h4>
    <table class="table">
        <tr>
            <th>#</th>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Статус</th>
            <th></th>
        </tr>
        <?php $a = 0; foreach ($listProfiles as $profile) : ?>
            <tr>
                <td><?= ++$a ?></td>
                <td><?= $profile->last_name ?> <?= $profile->first_name ?> <?= $profile->patronymic ?></td>
                <td><?= $profile->phone ?></td>
                <td><?= $profile->user->email ?></td>
                <td><?= !$profile->user->status ? 'Неактивный' : 'Активный' ?></td>
                <td> <?= Html::a('Перейти в ЛК',['by-user-id', 'id'=> $profile->user_id]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>