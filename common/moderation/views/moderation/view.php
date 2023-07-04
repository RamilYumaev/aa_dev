<?php

use modules\entrant\models\UserAis;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $moderation common\moderation\models\Moderation */
/* @var $userId integer */

$this->title = "Модерация. " . $moderation->getModel()->titleModeration();
$this->params['breadcrumbs'][] = ['label' => "Модерация", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/*if ($moderation->model !== \dictionary\models\DictSchools::class ||
    $moderation->model !== \modules\dictionary\models\DictOrganizations::class) {
    $modelData = $moderation->model::findOne($moderation->record_id);

    if ($modelData) {
        echo Html::a("Войти в кабинет пользователя", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $modelData->user_id,
            ['class' => 'btn btn-info', 'target' => '_blank']);

    }

}*/

if($userId)
{
    echo Html::a("Войти в кабинет пользователя", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $userId,
        ['class' => 'btn btn-info', 'target' => '_blank']);
}
$ais = UserAis::findOne(['user_id' => $moderation->created_by]);
$isEntrant = Yii::$app->authManager->getAssignment('entrant', $moderation->updated_by);
?>
<?= $isEntrant  ?  '<h4 class="warning">Редактировал сотрудник ЦПК</h4>' : ""; ?>
<?= ($ais ?  Html::tag("span", "Загружен в АИС", ['class' => "label label-success"]) : Html::tag("span", "Не загружен в АИС", ['class' => "label label-danger"]))  ?>
<div id="moderation-view">
    <div class="box">
        <div class="box-body table-responsive">
            <?= DetailView::widget(['model' => $moderation,
                // 'formatter' => ['class' => 'yii\i18n\Formatter','timeZone' => 'Europe/Moscow'],
                'attributes' => [
                    'model',
                    'record_id',
                    'message:html',    // description attribute in HTML
                    ['label' => $moderation->getAttributeLabel('created_by'),
                        'value' => \olympic\helpers\auth\ProfileHelper::profileShortName($moderation->created_by)
                    ],
                    ['label' => $moderation->getAttributeLabel('status'),
                        'value' => \common\moderation\helpers\ModerationHelper::statusName($moderation->status)],
                    ['label' => $moderation->getAttributeLabel('moderated_by'),
                        'value' => \olympic\helpers\auth\ProfileHelper::profileShortName($moderation->moderated_by)],
                    ['label' => $moderation->getAttributeLabel('updated_by'),
                        'value' => \olympic\helpers\auth\ProfileHelper::profileShortName($moderation->updated_by)
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],]) ?>
        </div>
    </div>
    <?php if($ais) :?>
    <div>
        <?= \common\moderation\widgets\ExportDataWidget::widget(['model' => $moderation->model, 'sdoId' => $moderation->record_id, 'id' => $moderation->id]); ?>
    </div>
    <?php endif; ?>
    <div>
        <?= \common\moderation\widgets\ModerationWidget::widget(['moderation' => $moderation]); ?>
    </div>
</div>