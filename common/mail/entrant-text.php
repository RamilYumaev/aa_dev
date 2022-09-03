<?php
/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
/* @var $time string */
/* @var $url string */
 ?>
<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!

<?= $text ?> <?=$url ?>,предварительно авторизовавшись в личном кабинете поступающего в МПГУ.
    <?php if($time) : ?>
    Начать экзамен рекомендуем в <?= $time ?> по МСК. До начала экзамена необходимо пройти процедуру идентификации и допуска к экзамену.
    Подробнее о прохождении дистанционного вступительного испытания Вы можете узнать по ссылке на инструкцию https://docs.google.com/document/d/1tG61PxT5x4ku9deJtYbZPCoJu6VF9xtuJ5xd9wIWLGo/edit
    или просмотрев видео-инструкцию https://www.youtube.com/watch?v=NUelbilye5Q&feature=youtu.be



    Техническая поддержка:
    support_priem@mpgu.edu,
    группы telegram, где можно согласовать другое время экзамена, а также проконсультироваться по различным вопросам:
    Для поступающих на программы бакалавриата: https://t.me/+ltXhe1C6PUE4N2Iy
    Для поступающих в магистратуру: https://t.me/+IeHReBSlLgtlOWQy
    Для поступающих в аспирантуру: https://t.me/+pcmmF8Lm-FE3MjQy

    Удачного экзамена!
    <?php endif; ?>
    Письмо сгенерировано автоматически и отвечать на него не нужно.
    С уважением,
    приемная комиссия МПГУ
    Сайт sdo.mpgu.org
