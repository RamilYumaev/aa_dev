<?php

use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\sending\helpers\SendingHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\sending\forms\DictSendingTemplateForm  */
/* @var $form yii\widgets\ActiveForm */

echo 'Для составления шаблона письма, Вы можете использовать следующие автопостановки:'.'<br/>';
echo '{имя отчество получателя}' . '<br/>';
echo '{название олимпиады в родительном падеже}' . '<br/>';
echo '{дата и время очного тура олимпиады}' . '<br/>';
echo '{адрес проведения очного тура}' . '<br/>';
echo '{Ф.И.О. председателя олимпиады}' . '<br/>';
echo '{1-е место, 2-е место, 3-е место}'. '<br/>';
echo '{ссылка на диплом}'.'<br/>';
echo '{ссылка на приглашение}'.'<br/>';
?>
<?php $form = ActiveForm::begin(['id' => 'form-sending-template-create-update-form', 'enableAjaxValidation' => true]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'html')->widget(CKEditor::class, [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]);?>
    <?= $form->field($model, 'text')->textarea(['row' => 6]); ?>

    <?php if (Yii::$app->user->can('admin_faculty')) : ?>

       <?= $form->field($model, 'check_status')->checkbox(); ?>
       <?= $form->field($model, 'base_type')->dropDownList(SendingHelper::typeTemplateList());?>

    <?php endif; ?>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>