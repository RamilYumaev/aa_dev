<?php
/* @var $this yii\web\View */
/* @var $anketa modules\entrant\models\Anketa */

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Загрузка документов';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
$userId =  Yii::$app->user->identity->getId();
?>

<div class="container">
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]). " Карточка",
                "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <h1 align="center"><?= $this->title ?></h1>
    <div class="row">
        <h4>Общие требования к файлам</h4>
        <p align="justify">
            <ol>
            <li>Оцифрованный документ в обязательном порядке должен включать в себя формирование копий формата JPEG, JPG и PNG;</li>
            <li>Допускается загрузка как чёрно-белых, так и цветных сканов;</li>
            <li>Разрешение отсканированного документа должно быть 300 DPI;</li>
            <li>Объем файла не должен превышать размер 5 МБ.</li>
        </ol>
        </p>
        <p align="justify">
            Настройки яркости и контраста должны быть выверены таким образом, чтобы чтение текста было максимально
            удобным. Все надписи, печати, подписи на документах должны быть хорошо различимы. Допускаются узкие поля
            по краям без присутствия посторонних предметов (частей тела, элементов одежды, т.п.).
        </p>
        <div class="col-md-12">
            <h4>Требования к согласию на обработку персональных данных:</h4>
            <p align="justify">Согласие на обработку персональных данных должно быть распечатано и подписано поступающим
                или его законным представителем (в соответствующем случае на лицевой стороне согласия вносятся данные
                законного представителя по предложенной форме, с обратной стороны ставит подпись представитель).
                Предоставляются обе стороны документа в формате печатного листа А4 двумя отдельными файлами.</p>
            <p class="label label-warning fs-15">Каждая страница заявления о согласии на обработку персональных данных
                загружается отдельно</p>
            <?= \modules\entrant\widgets\statement\StatementPersonalDataWidget::widget(['userId' => $userId]); ?>

            <h4>Требования к паспорту:</h4>
            <p align="justify">
                В образ паспорта должны быть включены все сведения, включая реквизиты (серию и номер) паспорта
                и фотографию гражданина. На фотографии не должно быть бликов, явных отражений голограмм.
                Предоставляются копии 2, 3 и 5 страниц (либо иной страницы, содержащей актуальные сведения
                о месте постоянной регистрации гражданина). Допускаются узкие поля по краям без присутствия
                посторонних предметов (частей тела, элементов одежды, т.п.).</p>
            <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => 'file', 'userId' => $userId]); ?>

            <?php if ($anketa->isOrphan()): ?>
                <?= \modules\entrant\widgets\passport\BirthDocumentWidget::widget(['view' => 'file-birth-document', 'userId' => $userId]); ?>
            <?php endif; ?>

            <?php if (!$anketa->isNoRequired()): ?>
                <?= \modules\entrant\widgets\address\AddressFileWidget::widget(['userId' => $userId]); ?>
            <?php endif; ?>
            <h4>Требования к документу об образовании:</h4>
            <p align="justify">В поле «Скан документа об образовании» загружается основная страница документа
                об образовании, включающая в себя серию и номер документа, дату выдачи и наименование образовательной
                организации. Приложение к документу загружается отдельными файлами. Допускаются узкие поля по краям
                без присутствия посторонних предметов (частей тела, элементов одежды, т.п.).</p>


            <?= \modules\entrant\widgets\education\DocumentEducationFileWidget::widget(['userId' => $userId]); ?>

            <?php if ($anketa->isAgreement()): ?>
                <p class="label label-warning fs-15">Каждая страница договора о целевом обучении загружается отдельно</p>
                <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view' => 'file', 'userId' => $userId]); ?>
            <?php endif; ?>
            <h4>Требования к фотографиям:</h4>
            <p align="justify">Тип фотографий – на документы. Допускается фотография, сделанная самостоятельно
                анфас на нейтральном фоне без бликов и теней, без присутствия посторонних предметов и иных лиц в кадре.</p>
            <?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget(['userId' => $userId]); ?>

            <p class="label label-warning fs-15">Каждая страница заявления об участии в конкурсе
                загружается отдельно</p>
            <?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget(['userId' => $userId,
                'formCategory' => DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1, 'eduLevel' =>
                    [DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL, DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER,
                        DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO]]);  ?>
            <?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget(['userId' => $userId, 'eduLevel' =>
                [DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL, DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO, DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR],
                'formCategory' =>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2]); ?>

            <?= \modules\entrant\widgets\statement\StatementCgConsentWidget::widget(['userId' => $userId]); ?>

            <?= \modules\entrant\widgets\statement\StatementIaWidget::widget(['userId' => $userId]); ?>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col-md-offset-4 col-md-4">
            <?= Html::a("Отправить в приемную комиссию", ['post-document/send'], ["class" => "btn btn-success btn-lg", 'data'=> ['method' => 'post']]) ?>
        </div>
    </div>
</div>
