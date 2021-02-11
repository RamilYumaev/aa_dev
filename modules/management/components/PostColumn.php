<?php

namespace modules\management\components;

use modules\management\models\ManagementUser;
use olympic\helpers\auth\RoleHelper;
use olympic\models\auth\AuthAssignment;
use yii\grid\DataColumn;
use yii\helpers\Html;


class PostColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = ManagementUser::find()->allColumnManagementUser($model->user_id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function ($post) {
            return $this->getPostLabel($post);
        }, $roles));
    }

    private function getPostLabel($post): string
    {
        return Html::tag('span', Html::encode($post), ['class' => 'label label-default']);
    }
}