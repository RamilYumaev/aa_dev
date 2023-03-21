<?php

/* @var $data array */
/* @var $olympicId int */

use yii\helpers\Html;
?>
<?php if ($data): ?>
<?php foreach ($data as $key => $subject) : ?>
    <h4><?= Html::a($subject, ['round', 'olympicId' => $olympicId, 'subject'=> $key]) ?></h4>
<?php endforeach; else: ?>
    <h4>Ничего не найдено</h4>
<?php endif; ?>
