<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
/* @var $time string */
/* @var $url string */

use yii\helpers\Html; ?>
<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!
<div>
    <?= $text ?>: <?= Html::a(Html::encode($url), $url) ?>
    ,предварительно авторизовавшись в личном кабинете поступающего в МПГУ. <br />
    <?php if($time) : ?>
        Начать экзамен рекомендуем в <?= $time?> по МСК. До начала экзамена необходимо пройти процедуру идентификации и допуска к экзамену. <br />
    Подробнее о прохождении дистанционного вступительного экзамена Вы можете узнать по ссылке на инструкцию : <?= Html::a(Html::encode('https://docs.google.com/document/d/1tG61PxT5x4ku9deJtYbZPCoJu6VF9xtuJ5xd9wIWLGo/edit'), 'https://docs.google.com/document/d/1tG61PxT5x4ku9deJtYbZPCoJu6VF9xtuJ5xd9wIWLGo/edit') ?>
        или просмотрев видео-инструкцию  <?= Html::a(Html::encode('https://www.youtube.com/watch?v=NUelbilye5Q&feature=youtu.be'), 'https://www.youtube.com/watch?v=NUelbilye5Q&feature=youtu.be') ?> <br />



        Техническая поддержка: <br />
        support_priem@mpgu.edu <br />
        группы telegram, где можно согласовать другое время экзамена, а также проконсультироваться по различным вопросам: <br />
        Для поступающих на программы бакалавриата: <?= Html::a(Html::encode('https://t.me/+ltXhe1C6PUE4N2Iy'),'https://t.me/+ltXhe1C6PUE4N2Iy' ) ?><br />
        Для поступающих в магистратуру: <?= Html::a(Html::encode('https://t.me/+IeHReBSlLgtlOWQy'),'https://t.me/+IeHReBSlLgtlOWQy' ) ?> <br />
        Для поступающих в аспирантуру: <?= Html::a(Html::encode('https://t.me/+pcmmF8Lm-FE3MjQy'),'https://t.me/+pcmmF8Lm-FE3MjQy' ) ?><br />

        Удачного экзамена!
    <?php endif; ?>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    <p>С уважением, <br/>
    приемная комиссия МПГУ<br/>
    Сайт sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>