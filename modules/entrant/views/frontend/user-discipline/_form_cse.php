<?php

/* @var $model modules\entrant\forms\UserDisciplineCseForm*/
/* @var $form yii\bootstrap\ActiveForm */
/* @var $data array */

use yii\bootstrap\ActiveForm;
use modules\entrant\models\UserDiscipline;
use dictionary\models\DictDiscipline;
use yii\helpers\Html;

$data  = $model->type == UserDiscipline::CSE  ?  DictDiscipline::find()->cseColumnsAll() : DictDiscipline::find()->ctColumnsAll();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <div>
                <?php $form = ActiveForm::begin(['id'=> 'form-cse-subject']); ?>
                        <td><?= $form->field($model, "discipline_id")->dropDownList($data) ?></td>
                        <td><?= $form->field($model, "mark")->textInput(['maxlength' => true])  ?></td>
                        <td><?= $form->field($model, "year")->textInput(['maxlength' => true])  ?></td>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>