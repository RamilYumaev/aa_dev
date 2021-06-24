<?php

/** @var $data array */
/** @var $this \yii\web\View*/
/** @var $model modules\dictionary\models\CompetitionList */
/** @var $cg dictionary\models\DictCompetitiveGroup */
use modules\entrant\helpers\DateFormatHelper;
$cg = $model->registerCompetitionList->cg;
$this->title = $cg->getFullNameCg();
$subjectType = [1 => 'ЕГЭ', 2 => 'ЦТ', 3 => 'ВИ', 4 => 'СБА'];
$subjectStatus =[ 1 => 'не проверено', 2 => 'проверено', 3 => 'ниже минимума' , 4 => 'истек срок'];

function converterExam(array $array) {
    foreach ($array as $key => $subject) {
       if($subject['subject_type_id'] == 1){

       }
    }
}

?>

    <div class=" col-offset-md-3 col-md-9" >
        <p style="font-size: 15px; margin-top: 30px">
        <span style="display: block; text-align: center">
            ФГБОУ ВО
            "Московский педагогический государственный университет" <br/>
            Учебный год 2021/2022<br/><br/><br/>
            </span>

            <span style="font-weight: bold"> Дата публикации списка и время обновления: </span><?= DateFormatHelper::format($data['date_time'], 'd.m.Y. H:i')?><br/>
            <span style="font-weight: bold">Категория поступающих: </span><?= $model->getTypeName($cg->special_right_id) ?><br/>
            <span style="font-weight: bold">Структурное подразделение: </span><?= $cg->faculty->full_name ?><br/>
            <span style="font-weight: bold">Направление подготовки: </span><?= $cg->specialty->codeWithName ?><br/>
            <span style="font-weight: bold">Уровень образования: </span><?= $cg->eduLevelFull ?><br/>
            <?php if($cg->specialisationName): ?>
                <span style="font-weight: bold">Профиль(и): </span><?= $cg->specialisationName ?><br/>
            <?php endif; ?>
            <span style="font-weight: bold">Форма обучения: </span><?= $cg->formEdu ?><br/>
            <span style="font-weight: bold">Вид финансирования: </span><?= $cg->finance ?><br/>
            <?php if($cg->isContractCg()) : ?>
                <span style="font-weight: bold">Стоимость обучения:  </span><?= key_exists('price_per_semester', $data['kcp']) ? $data['kcp']['price_per_semester'].' руб. за семестр' : ''?> <br/>
            <?php endif; ?>
            <?php if ($cg->isBudget()) : ?>
                <span style="font-weight: bold">Контрольные цифры приема:</span>
                <?php if (is_null($cg->special_right_id)) : ?>
                    <?= $data['kcp']['sum'] ?>,
                    квота - <?= $data['kcp']['quota'] ?>,
                    целевые - <?= $data['kcp']['target'] ?>
                <?php elseif ($cg->isKvota()): ?>
                    <?= $data['kcp']['quota'] ?>,
                <?php elseif ($cg->isTarget()): ?>
                    <?=  $data['kcp']['target']  ?>,
                <?php endif; ?>
                <?php /* $data['kcp']['transferred'] ?? '' */ ?><br/>
            <?php endif; ?>
        </p>
    </div>
</div>
<div style="margin-top: 80px">
        <?php if(key_exists($model->type, $data) && count($data[$model->type])):?>
            <div class="table-responsive">
            <table class="table" >
                <tr>
                    <th style="font-size: 12px; text-align: center">№ п/п</th>
                    <th style="font-size: 12px; text-align: center">Уникальный номер/СНИЛС</th>
                    <?php if(!Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant')): ?>
                    <th style="font-size: 12px; text-align:center">Фамилия Имя Отчество</th>
                    <?php endif; ?>
                    <th style="font-size: 12px; text-align: center">Сумма баллов</th>
                    <?php foreach ($cg->getExaminationsAisId() as $value) : ?>
                        <th style="font-size: 12px; text-align: center"><?= $value ?></th>
                    <?php endforeach; ?>
                    <th style="font-size: 12px; text-align: center">Сумма баллов за все предметы ВИ</th>
                    <th style="font-size: 12px; text-align: center">Индивидуальные достижения</th>
                    <th style="font-size: 12px; text-align: center">Сумма баллов за все ИД</th>
                  <!--  <th style="font-size: 12px; text-align: center">Подача документа об образовании</th> -->
                    <th style="font-size: 12px; text-align: center">Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <?php if($cg->isTarget()) : ?>
                        <th style="font-size: 12px; text-align: center">Наименование целевой организации</th>
                    <?php endif; ?>
                    <?php if($model->isBvi()):?>
                        <th style="font-size: 12px; text-align: center">Основание приема без ВИ</th>
                    <?php endif; ?>
                    <th style="font-size: 12px; text-align: center">Нуждается в общежитии</th>
                    <?php if($cg->isContractCg()) : ?>
                        <th style="font-size: 12px; text-align: center">Оплатил да/нет</th>
                    <?php endif; ?>
                    <th style="font-size: 12px; text-align: center">Примечание</th>
                    <th style="font-size: 12px; text-align: center">Дата приема заявлений</th>
                </tr>
                <?php  $i=1; foreach ($data[$model->type] as $entrant): ?>
                <tr <?=!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->incomingId() == $entrant['incoming_id'] ? 'class="success"': ''  ?> >
                    <td style="font-size: 14px; text-align: center"><?=$i++?></td>
                    <td style="font-size: 14px; text-align: center"><?= key_exists('snils', $entrant) ? ($entrant['snils'] ? $entrant['snils'] : $entrant['incoming_id']) : $entrant['incoming_id'] ?></td>
                    <?php if(!Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant')): ?>
                    <td style="font-size: 14px; text-align: center"> <?= $entrant['last_name']." ". $entrant['first_name']." ". $entrant['patronymic'] ?></td>
                    <?php endif; ?>
                    <td style="font-size: 14px; text-align: center"><?= $entrant['total_sum']?></td>
                    <?php foreach ($cg->getExaminationsAisId() as $aisKey => $value) :
                        $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                        $subject = $entrant['subjects'][$key];
                        ?>
                        <td style="font-size: 14px; text-align: center">
                            <?= (key_exists('ball', $subject) && $subject['ball'] ? $subject['ball'].", " : '') ?>
                            <?= $subjectType[$subject['subject_type_id']] ?>
                            <?=  key_exists('check_status_id', $subject) && $subject['check_status_id'] ? ", ".$subjectStatus[$subject['check_status_id']] : ''?>
                        </td>
                    <?php endforeach; ?>
                    <td style="font-size: 14px; text-align: center"><?= $entrant['subject_sum']?></td>
                    <td style="font-size: 14px; text-align: center">
                        <?php if(key_exists('individual_achievements', $entrant)) :?>
                            <?php echo implode(', ', array_map(function($individual_achievement)
                            { return $individual_achievement['individual_achievement_name'].' - '. $individual_achievement['ball'];}, $entrant['individual_achievements'])); ?>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 14px; text-align: center"><?= $entrant['sum_of_individual']?></td>
                 <!--   <td style="font-size: 14px; text-align: center"><?php /* $entrant['original_status_id'] ? 'оригинал': 'копия' */ ?></td> -->
                    <td style="font-size: 14px; text-align: center"><?= $entrant['zos_status_id'] ? '+': '-'?></td>
                    <?php if($cg->isTarget()) : ?>
                        <td style="font-size: 14px; text-align: center"><?= $entrant['target_organization_name'] ?></td >
                    <?php endif; ?>
                    <?php if($model->isBvi()):?>
                        <td style="font-size: 14px; text-align: center"><?= $entrant['bvi_right'] ?></td>
                    <?php endif; ?>
                    <td style="font-size: 14px; text-align: center"><?= $entrant['hostel_need_status_id'] ? 'Да': 'Нет'?></td>
                    <?php if($cg->isContractCg()) : ?>
                        <td><?= $entrant['payment_status'] ? 'Да': 'Нет'?></td>
                    <?php endif; ?>
                    <td style="font-size: 14px; text-align: center"><?= key_exists('pp_status_id',$entrant) && $entrant['pp_status_id'] ? "ПП" : ''?></td>
                    <td style="font-size: 14px; text-align: center"><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
                    <?php endforeach; ?>
                </tr>
            </table>
            </div>
        <?php else: ?>
            <h4 style="color: red">в списке нет ни одного абитуриента</h4>
        <?php endif; ?>
 </div>