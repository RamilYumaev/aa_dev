<?php
/* @var $this yii\web\View */
/* @var $model \olympic\models\OlimpicList */
/* @var $allTemplates \dictionary\models\OlimpiadsTypeTemplates */

use yii\helpers\Html;
use yii\helpers\Url;
use dictionary\helpers\TemplatesHelper;
?>

<?php if ($allTemplates && !$model->prefilling) : ?>
<div>
    <?php foreach ($allTemplates as $template) : ?>
    <?php $url = Url::to(['print/olimp-docs', 'template_id' => $template->template_id, 'olympic_id' => $model->id]); ?>
        <div>
            <a href="<?= Html::encode($url) ?>">
                <h5><?= TemplatesHelper::templatesNameForUser($template->template_id) ?></h5>
            </a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>