<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $type  string */

$noPatriot = $type !== "patriot";
if ($other) :
$column =  [
    'series',
    'number',
    'date:date',
];

if ($noPatriot) {
    array_push($column, ['label' => $other->getAttributeLabel('type'),
        'value' => $other->typeName,],
        ['label' => $other->getAttributeLabel('exemption_id'),
            'value' => $other->exemption,]);
}
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($other ?? false) ?>">
        <h4><?= $noPatriot ? "Документ, подтверждающий льготы.":
                "Документ, подтверждающий принадлежность к соотечественникам за рубежом"?></h4>
        <?= Html::a('Редактировать', [ $noPatriot ? 'other-document/exemption' : 'other-document/patriot'],
            ['class' => 'btn btn-primary']) ?>
        <?= DetailView::widget([
            'options' => ['class' => 'table table-bordered detail-view'],
            'model' => $other,
            'attributes' => $column
        ]) ?>

    </div>
</div>
<?php endif; ?>