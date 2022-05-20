<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $type  string */
/* @var $exemption array | null */

$noPatriot = $type !== "patriot";
$title = !in_array(4, $exemption) ? "Документ, подтверждающий льготы." : "Документ выданный детям военнослужащих и сотрудников, поступающим на обучение в	образовательные организации,
подтверждающих право на прием в соответствии с Указом Президента РФ №268 от 09.05.2022г., федеральным органам исполнительной власти и 
федеральным государственным органам, в которых федеральным законом предусмотрена военная служба, федеральному органу исполнительной власти, осуществляющему функции по выработке и реализации государственной политики и нормативно-правовому регулированию в сфере внутренних дел";
$stringUrl = !in_array(4, $exemption) ? 'other-document/exemption' : 'other-document/special-quota';

?>
<div class="row">
    <div class="col-md-12
<?= BlockRedGreenHelper::colorBg($other ?? false) ?>">
        <div class="p-30 green-border">
            <h4><?= $noPatriot ? $title:
                    "Документ, подтверждающий принадлежность к соотечественникам за рубежом" ?></h4>
            <?php
            if ($other) :
                $column = [
                    'series',
                    'number',
                    'date:date',
                ];

                if ($noPatriot) {
                    array_push($column, ['label' => $other->getAttributeLabel('type'),
                        'value' => $other->typeName,]);
                }

                if (!in_array(4, $exemption)) {
                    array_push($column,
                        ['label' => $other->getAttributeLabel('exemption_id'),
                            'value' => $other->exemption,]);
                }
                ?>
                <?= Html::a('Редактировать', [$noPatriot ? $stringUrl : 'other-document/patriot'],
                ['class' => 'btn btn-success']) ?>
                <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $other,
                'attributes' => $column
            ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить', [$noPatriot ? $stringUrl : 'other-document/patriot'],
                    ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
