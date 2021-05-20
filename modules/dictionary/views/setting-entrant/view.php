<?php

use dictionary\helpers\DictSpecializationHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\SelectDataHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictCompetitiveGroupSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model modules\dictionary\models\SettingEntrant */

$this->title = 'Настройки приема. Конкурсные группы ' . $model->string;
$this->params['breadcrumbs'][] = ['label' => 'Настройки приема', 'url' => ['setting-entrant/index']];
$this->params['breadcrumbs'][] = $this->title; ?>
    <div class="dict-coml-group-index">
        <div class="box table-responsive">
            <div class="box-body">
            <?= $this->render($model->isGraduate() ? '_table_graduate': '_table',['model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,]) ?>
            </div>
        </div>
    </div>
