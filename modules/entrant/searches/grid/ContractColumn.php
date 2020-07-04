<?php

namespace modules\entrant\searches\grid;

use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\ContractHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;


class ContractColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return Html::tag('span', Html::encode($model->statusName), ['class' => 'label label-' . ContractHelper::colorName($model->status_id)]);
    }
}