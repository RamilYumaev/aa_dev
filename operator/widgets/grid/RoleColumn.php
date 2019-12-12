<?php

namespace operator\widgets\grid;

use olympic\helpers\auth\RoleHelper;
use olympic\models\auth\AuthAssignment;
use yii\grid\DataColumn;
use yii\helpers\Html;


class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = AuthAssignment::getRoleName($model->id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function ($role) {
            return $this->getRoleLabel($role);
        }, $roles));
    }

    private function getRoleLabel($role): string
    {
        $class = $role == RoleHelper::ROLE_USER ? 'primary' : 'danger';
        return Html::tag('span', Html::encode($role), ['class' => 'label label-' . $class]);
    }
}