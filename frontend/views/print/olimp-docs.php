<?php
/**
 * @var $olimpiad \olympic\models\OlimpicList
 * @var $result
 */
$this->title = 'Документы конкурса/олимпиады: '.$olimpiad->name;
?>
<div class="container">
    <div class="row printDiv">
        <?= $result ?>
    </div>
</div>