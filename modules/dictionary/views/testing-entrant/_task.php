<?php
/* @var $model modules\dictionary\forms\TestingEntrantForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\dictionary\models\DictTestingEntrant;
use yii\db\Expression;

?>
<?= $form->field($model, 'dictTestingList')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => DictTestingEntrant::find()->select(new Expression("concat_ws('/', name, priority)"))->indexBy('id')
                ->orderBy(['priority'=> SORT_ASC])->column()
        ]) ?>