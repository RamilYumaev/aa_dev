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
        Начать экзамен рекомендуем в <?= $time?> по МСК. Предварительно необходимо пройти процедуру индентификации и допуска к экзамену. Начать идентификацию рекомендуем за полчаса до начала экзамена.  <br />
    Подробнее о прохождении дистанционного вступительного экзамена Вы можете узнать по ссылке на инструкцию : <?= Html::a(Html::encode('https://docs.google.com/document/d/1tG61PxT5x4ku9deJtYbZPCoJu6VF9xtuJ5xd9wIWLGo/edit'), 'https://docs.google.com/document/d/1tG61PxT5x4ku9deJtYbZPCoJu6VF9xtuJ5xd9wIWLGo/edit') ?>
        или просмотрев видео-инструкцию  <?= Html::a(Html::encode('https://www.youtube.com/watch?v=NUelbilye5Q&feature=youtu.be'), 'https://www.youtube.com/watch?v=NUelbilye5Q&feature=youtu.be') ?> <br />

        Телефоны для связи с прокторами: <br />
        84994000248 добавочные номера: 691, 625, 659, 692, 640, 657, 658. <br />

        Техническая поддержка: <br />
        support_priem@mpgu.edu <br />
        группы телеграмм: <br />
        Для поступающих на программы бакалавриата: <?= Html::a(Html::encode('https://t.me/joinchat/NO93UQnWOrAk_Gli9_H-Og'),'https://t.me/joinchat/NO93UQnWOrAk_Gli9_H-Og' ) ?><br />
        Для поступающих в магистратуру: <?= Html::a(Html::encode('https://t.me/joinchat/NO93URlERkWTRmi0J-qNdg'),'https://t.me/joinchat/NO93URlERkWTRmi0J-qNdg' ) ?> <br />
        Для поступающих в аспирантуру: <?= Html::a(Html::encode('https://t.me/joinchat/NO93URipPcKHwb3BKTbxVw'),'https://t.me/joinchat/NO93URipPcKHwb3BKTbxVw' ) ?><br />

        Удачного экзамена!
    <?php endif; ?>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    <p>С уважением, <br/>
    приемная комиссия МПГУ<br/>
    Сайт sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>