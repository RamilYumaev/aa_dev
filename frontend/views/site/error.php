<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container mt-30 site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Данная ошибка произошла во время выполнения Вашего запроса сервером.
    </p>
    <p>
        Пожалуйста сообщите нам об ошибке, написав письмо support_priem@mpgu.edu и мы примем все необходимые меры. Спасибо!
    </p>

</div>
