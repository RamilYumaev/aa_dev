<?php

namespace modules\entrant\searches\grid;

use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\FileHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;


class FileColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return $this->countFiles($model)." ".$this->countNewFiles($model)." ".$this->countSuccessFiles($model)." ".$this->countDangerFiles($model);
    }

    private function countFiles($model) {
        return Html::tag('span', Html::encode($model->countFiles()), ['class' => 'label label-default']);
    }

    private function countNewFiles($model) {
        return Html::tag('span', Html::encode($model->countStatusFiles(FileHelper::STATUS_WALT)), ['class' => 'label label-warning']);
    }

    private function countSuccessFiles($model) {
        return Html::tag('span', Html::encode($model->countStatusFiles(FileHelper::STATUS_ACCEPTED)), ['class' => 'label label-success']);
    }

    private function countDangerFiles($model) {
        return Html::tag('span', Html::encode($model->countStatusFiles(FileHelper::STATUS_NO_ACCEPTED)), ['class' => 'label label-danger']);
    }



}