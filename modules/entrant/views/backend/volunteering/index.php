<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\dictionary\forms\VolunteeringForm /
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\dictionary\models\Volunteering;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\jui\Dialog;

$this->title = "Волонтерство. Дополнительная информация";
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
<div class="box box-primary">
    <div class="box-header">Добавление/Редактирование информации</div>
    <div class="box-body">
        <?= $form->field($model, 'faculty_id')->dropDownList(\dictionary\helpers\DictFacultyHelper::facultyList())?>
        <?= $form->field($model, 'number_edu')->textInput() ?>
        <?= $form->field($model, 'course_edu')->dropDownList(\dictionary\helpers\DictClassHelper::getListMPSU())?>
        <?= $form->field($model, 'form_edu')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduForms()) ?>
        <?= $form->field($model, 'finance_edu')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::listFinances())?>
        <?= $form->field($model, 'experience')->checkbox() ?>
        <?= $form->field($model, 'clothes_type')->dropDownList(\olympic\helpers\auth\ProfileHelper::typeOfGender()) ?>
        <?= $form->field($model, 'clothes_size')->dropDownList((new Volunteering())->listClothesSize())  ?>
        <div class="row">
            <div class="col-md-10">
                <?= $form->field($model, 'desire_work')->widget(\kartik\select2\Select2::class, [
                    'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                    'data' => \modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories()
                ]) ?>
            </div>
            <div class="col-md-2">
                <?php
                Modal::begin([
                    'header' => '<h2>Направления работы</h2>',
                    'toggleButton' => [
                        'label' => 'Подробно',
                        'tag' => 'button',
                         'style' => ['margin-top'=> "25px"],
                        'class' => 'btn btn-info btn-block',
                    ],
                ]);
                ?>
                <p><b>Call-центр (прием телефонных звонков) и Центр информации (живое общение):</b></p>
                <ul>
                    <li>консультирование поступающих по реализуемым образовательным программам и условиям приема в МПГУ;</li>
                    <li>оперативная навигация по электронным ресурсам и сервисам МПГУ.</li>
                </ul>
                <p><b>Центр регистрации (личный прием, живое общение) и "Почта" (обработка документа на бумажном носителе):</b></p>
                <ul>
                    <li>обработка документов и регистрация поступающих, формирование и печать пакета «Личное дело».</li>
                </ul>
                <p><b>Центр прокторинга (вступительные испытания в формате онлайн):</b></p>
                <ul>
                    <li>информационное и контрольное сопровождение вступительного испытания поступающего.</li>
                </ul>
                <p><b>Центр обработки заявлений:</b></p>
                <ul>
                    <li>техническая поддержка работы филиалов МПГУ, отборочных комиссий институтов и факультетов и другие задачи.</li>
                </ul>
                <?php Modal::end(); ?>
            </div>
        </div>
        <?= $form->field($model, 'note')->textarea() ?>
        <?= $form->field($model, 'link_vk')->textInput() ?>
    </div>
    <div class="box-footer"> <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?></div>
</div>