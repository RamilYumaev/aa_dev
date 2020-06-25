<?php

namespace modules\entrant\searches\grid;

use modules\entrant\helpers\AgreementHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;


class AgreementColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return Html::tag('span', Html::encode($model->statusName), ['class' => 'label label-' . AgreementHelper::colorName($model->status_id)]);
    }
}