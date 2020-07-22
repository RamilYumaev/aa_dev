<?php

/* @var $this \yii\web\View */

/* @var $content string */

use dmstr\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php if (!($_SERVER['HTTP_HOST'] === 'aa:8080' or $_SERVER['HTTP_HOST'] == 'sdotest.3profi.ru')) : ?>

        <script type="text/javascript" src="https://vk.com/js/api/openapi.js?165"></script>
    <?php endif; ?>
</head>
<body>

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    require_once('_menu.php');
    ?>
    <div class="pl-50 mt-30 gray">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
    <?php
    require_once ('switcher-user.php');
    ?>
    <div class="container-fluid">
            <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php if ($_SERVER['HTTP_HOST'] == 'sdo.mpgu.org') : ?>


    <!-- VK Widget -->
    <div id="vk_community_messages"></div>
    <script type="text/javascript">
        VK.Widgets.CommunityMessages("vk_community_messages", 191157288, {disableExpandChatSound: "1",tooltipButtonText: "Есть вопрос?"});    </script>

<?php endif; ?>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ФГБОУ ВО "Московский педагогический государственный
            университет" <?= date('Y') ?> <a href="mailto:olimp@mpgu.su">olimp@mpgu.su</a></p>

    </div>
</footer>


<?php if (!($_SERVER['HTTP_HOST'] === 'olympic:8080' or $_SERVER['HTTP_HOST'] == 'sdotest.3profi.ru')) : ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter33850889 = new Ya.Metrika({
                        id: 33850889,
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true,
                        webvisor: true
                    });
                } catch (e) {
                }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks");
    </script>

    <noscript>
        <div><img src="https://mc.yandex.ru/watch/33850889" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

<?php endif; ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
