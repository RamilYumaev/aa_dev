<?php
/* @var $model modules\exam\forms\ExamDateReserveForm */
/* @var $form yii\bootstrap\ActiveForm */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\exam\helpers\ExamCgUserHelper;
use yii\helpers\Html;

?>
<?php if(ExamCgUserHelper::isTimeZa()) : ?>
    <?= Html::a('Формирование заявок (БАК.З)',['all-statement-create',
        'eduLevel' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
        'formCategory'=>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2], ['class'=> "btn btn-success", 'data'=> ['method'=> 'post', 'confirm'=> 'Вы уверены, что хотите сделать?']])?>
    <?= Html::a('Формирование заявок (МАГ.З)',['all-statement-create',
        'eduLevel' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER,
        'formCategory'=>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2], ['class'=> "btn btn-primary", 'data'=> ['method'=> 'post', 'confirm'=> 'Вы уверены, что хотите сделать?']])?>
    <?= Html::a('Формирование заявок (АСП.З)',['all-statement-create',
        'eduLevel' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL,
        'formCategory'=>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2], ['class'=> "btn btn-warning", 'data'=> ['method'=> 'post', 'confirm'=> 'Вы уверены, что хотите сделать?']])?>
<?php else: ?>
    <?= Html::a('Формирование заявок (БАК)',['all-statement-create',
        'eduLevel' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
        'formCategory'=>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1], ['class'=> "btn btn-success", 'data'=> ['method'=> 'post', 'confirm'=> 'Вы уверены, что хотите сделать?']])?>
    <?= Html::a('Формирование заявок (МАГ)',['all-statement-create',
        'eduLevel' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER,
        'formCategory'=>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1], ['class'=> "btn btn-primary", 'data'=> ['method'=> 'post', 'confirm'=> 'Вы уверены, что хотите сделать?']])?>
    <?= Html::a('Формирование заявок (АСП)',['all-statement-create',
        'eduLevel' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL,
        'formCategory'=>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1], ['class'=> "btn btn-warning", 'data'=> ['method'=> 'post', 'confirm'=> 'Вы уверены, что хотите сделать?']])?>
<?php endif; ?>