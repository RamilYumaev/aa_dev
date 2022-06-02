<?php

/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */
/* @var $fields array */
/* @var $model \yii\base\DynamicModel */
use kartik\select2\Select2; ?>

<div class="forms_data">
    <?php if($fields && $model) :
        foreach($fields['names'] as $value): ?>
            <?php if(key_exists('clsName', $fields) && key_exists($value, $fields['clsName'])):
                /** @var \modules\superservice\components\DataXml $class */
                $class = '\\modules\\superservice\\components\\data\\'.$fields['clsName'][$value]; ?>
                <?= $form->field($model, $value)->widget(Select2::class, [
                'data' =>(new $class())->getDefaultMap(),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ]]) ?>
            <?php  elseif(key_exists('boolean', $fields["formats"]) && in_array($value, $fields["formats"]['boolean'])): ?>
                <?= $form->field($model, $value)->checkbox() ?>
            <?php else: ?>
                <?= $form->field($model, $value)->textInput() ?>
            <?php endif;
        endforeach;
    endif; ?>
</div>

