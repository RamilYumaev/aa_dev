<?php
/* @var $model modules\dictionary\forms\TestingEntrantForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\dictionary\models\DictTestingEntrant;
?>
<?= $form->field($model, 'dictTestingList')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => DictTestingEntrant::find()->select('name')->indexBy('id')->column()
        ]) ?>