<?php

namespace backend\widgets\grid;

use common\auth\rbac\Rbac;
use common\models\auth\AuthAssignment;
use common\models\auth\AuthItem;
use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\rbac\Item;

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
        $class = $role == Rbac::ROLE_USER ? 'primary' : 'danger';
        return Html::tag('span', Html::encode($role), ['class' => 'label label-' . $class]);
    }
}