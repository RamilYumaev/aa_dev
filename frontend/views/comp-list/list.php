<?php
/**
 * @var $this View
 * @var $kcp array
 * @var $model \modules\entrant\modules\ones_2024\model\CgSS
 */

use modules\entrant\helpers\DateFormatHelper;
use yii\helpers\Html;
use yii\web\View;

$this->title = $model->name ;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['comp-list/index']];
$this->params['breadcrumbs'][] = ['label' => $model->faculty->full_name, 'url' => ['comp-list/view', 'faculty_id' => $model->faculty_id]];
$this->params['breadcrumbs'][] = $this->title;
$isContract = $model->type == "По договору об оказании платных образовательных услуг";
$isTarget = $model->type == "Целевая квота";
$isMain = $model->type == "Основные места в рамках КЦП";
$list = $model->getList();
if($list) {
    $list = array_filter($list, function ($b) {
        return !empty($b['number']);
    });
}
?>
<div class="container" style="position: relative">
    <div class="row">
        <div class=" col-offset-md-3 col-md-9">
            <p style="font-size: 15px; margin-top: 30px">
                <span style="display: block; text-align: center">
                    ФГБОУ ВО
                    "Московский педагогический государственный университет" <br/>
                    Учебный год 2024/2025<br/><br/><br/>
                    </span>
                <span style="font-weight: bold"> Дата публикации списка и время обновления: </span>
                <?= DateFormatHelper::format($model->datetime_url, 'd.m.Y. H:i')?><br/>
                <span style="font-weight: bold">Категория поступающих: </span><?= $model->type?><br/>
                <span style="font-weight: bold">Структурное подразделение: </span><?= $model->faculty->full_name ?><br/>
                <span style="font-weight: bold">Направление подготовки: </span><?= $model->code_spec.' '.$model->speciality?><br/>
                <span style="font-weight: bold">Уровень образования: </span><?= $model->education_level ?><br/>
                <span style="font-weight: bold">Профиль(и): </span><?= $model->profile ?><br/>
                <span style="font-weight: bold">Форма обучения: </span><?= $model->education_form ?><br/>
                <span style="font-weight: bold">Вид финансирования: </span><?= $isContract ? 'Договор': 'Бюджет'?><br/>
                <?php if (!$isContract) : ?>
                    <span style="font-weight: bold">Контрольные цифры приема:</span>
                        <?= $model->kcp ?>
                        <?php if($isMain && $kcp) : ?>
                        из них: <?php foreach ($kcp as $key => $item) : ?>
                        <?= Html::a(mb_strtolower($item['type']), ['list', 'id' => $item['id']],
                            ['target' => '_blank']) ?> - <?= $item['kcp'] ?><?= $key +1 == count($kcp) ? '.': ', ' ?>
                <?php endforeach; endif; endif; ?>
            </p>
        </div>
    </div>
</div>
<div class="container-fluid">
    <?php if ($list) : ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th style="font-size: 12px; text-align: center">№ п/п</th>
                <th style="font-size: 12px; text-align: center">Уникальный номер/СНИЛС</th>
                <th style="font-size: 12px; text-align: center">Вступительное испытание 1</th>
                <th style="font-size: 12px; text-align: center">Вступительное испытание 2</th>
                <th style="font-size: 12px; text-align: center">Вступительное испытание 3</th>
                <th style="font-size: 12px; text-align: center">Сумма баллов за все предметы ВИ</th>
                <th style="font-size: 12px; text-align: center">Сумма баллов по ИД для конкурса</th>
                <th style="font-size: 12px; text-align: center">Сумма баллов</th>
                <th style="font-size: 12px; text-align: center">Набор вступительных испытаний</th>
                <th style="font-size: 12px; text-align: center">Приоритет</th>
                <th style="font-size: 12px; text-align: center">Оригинал</th>
                <th style="font-size: 12px; text-align: center">Документ</th>
                <th style="font-size: 12px; text-align: center">Нуждается в общежитии</th>
                <?php if($isContract) : ?>
                    <th style="font-size: 12px; text-align: center">Оплатил да/нет</th>
                <?php endif; ?>
                <?php if($isTarget) : ?>
                    <th style="font-size: 12px; text-align: center">Наименование целевой организации</th>
                <?php endif; ?>
                <th style="font-size: 12px; text-align: center">Примечание</th>
            </tr>
            <?php foreach ($list as $item) : ?>
            <tr>
                <td style="font-size: 14px; text-align: center"><?= $item['number'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['snils_number'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['exam_1'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['exam_2'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['exam_3'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['sum_exams'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['sum_individual'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['sum_ball'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['name_exams'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['priority'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['original'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['document'] ?></td>
                <td style="font-size: 14px; text-align: center"><?= $item['is_hostel'] ? 'да' : 'нет' ?></td>
                <?php if($isContract) : ?>
                <td style="font-size: 14px; text-align: center"><?= $item['is_pay'] ?></td>
                <?php endif; ?>
                <?php if($isTarget) : ?>
                <td style="font-size: 14px; text-align: center"><?= $item['organization'] ?></td>
                <?php endif; ?>
                <td style="font-size: 14px; text-align: center"><?= $item['right'] == "Да" ? "ПП": ""?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php else: ?>
    <h4 style="color: red">В списке нет ни одного абитуриента</h4>
  <?php endif; ?>
</div>
