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
 ?>
<div class="row">
    <div class="col-md-12">
        <p>
            Федеральное государственное бюджетное образовательное учреждение высшего образования
            "Московский педагогический государственный университет" <br/>
            учебный год <?= $data['year']?>,<br/>
            дата публикации списка и время обновления <?= DateFormatHelper::format($data['date_time'], 'd.m.Y. H:i')?><br/>
            категория поступающих <?= $model->getTypeName($cg->special_right_id) ?>,<br/>
            Структурное подразделение: <?= $cg->faculty->full_name ?>,<br/>
            направление подготовки <?= $cg->specialty->codeWithName ?>,<br/>
            уровень образования <?= $cg->eduLevelFull ?>,<br/>
            <?php if($cg->specialisationName): ?>
            профиль(и) <?= $cg->specialisationName ?>,<br/>
            <?php endif; ?>
            форма обучения <?= $cg->formEdu ?>,<br/>
            вид финансирования <?= $cg->finance ?>,<br/>
            <?php if($cg->isContractCg()) : ?>
            стоимость обучения  <?= key_exists('price_per_semester', $data) ? $data['price_per_semester'] : ''?> <br/>
            <?php endif; ?>
            <?php if ($cg->isBudget()) : ?>
            контрольные цифры приема:
                <?php if (is_null($cg->special_right_id)) : ?>
                <?= $data['kcp']['sum'] ?>,
                     квота - <?= $data['kcp']['quota'] ?>,
                    целевые - <?= $data['kcp']['target'] ?>
                <?php elseif ($cg->isKvota()): ?>
                    <?= $data['kcp']['quota'] ?>,
                <?php elseif ($cg->isTarget()): ?>
                <?=  $data['kcp']['target']  ?>,
                <?php endif; ?>
            <?= $data['kcp']['transferred'] ?? '' ?>,<br/>
            <?php endif; ?>
        </p>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <?php if(key_exists($model->type, $data) && count($data[$model->type])):?>
            <table class="table table">
                <tr>
                    <th>№ п/п</th>
                    <th>СНИЛС</th>
                    <th>Сумма баллов</th>
                    <?php foreach ($cg->getExaminationsAisId() as $value) : ?>
                        <th><?= $value ?></th>
                    <?php endforeach; ?>
                    <th>Сумма баллов за все предметы ВИ</th>
                    <th>Индивидуальные достижения</th>
                    <th>Сумма баллов за все ИД</th>
                    <th>Подача документа об образовании</th>
                    <th>Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <?php if($cg->isTarget()) : ?>
                        <th>Наименование целевой организации</th>
                    <?php endif; ?>
                    <?php if($model->isBvi()):?>
                        <th>Основание приема без ВИ</th>
                    <?php endif; ?>
                    <th>Нуждается в общежитии</th>
                    <?php if($cg->isContractCg()) : ?>
                    <th>Оплатил да/нет</th>
                    <?php endif; ?>
                    <th>Примечание</th>
                    <th>Дата приема заявлений</th>
                </tr>
                <?php  $i=1; foreach ($data[$model->type] as $entrant): ?>
                <tr <?=!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->incomingId() == $entrant['incoming_id'] ? 'class="success"': ''  ?> >
                    <td><?=$i++?></td>
                    <td><?= key_exists('snils', $entrant) ? $entrant['snils'] : ""?></td>
                    <td><?= $entrant['total_sum']?></td>
                    <?php foreach ($cg->getExaminationsAisId() as $aisKey => $value) :
                        $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                        $subject = $entrant['subjects'][$key];
                    ?>
                        <td><?php if(is_int($key)):?>
                                <?= (key_exists('ball', $subject) ? $subject['ball'].", " : '') ?>
                                <?= $subjectType[$subject['subject_type_id']] ?>
                                <?=  key_exists('check_status_id', $subject) ? ", ".(key_exists($subject['check_status_id'], $subjectStatus) ? $subjectStatus[$subject['check_status_id']] :''): ''?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td><?= $entrant['subject_sum']?></td>
                    <td>
                    <?php if(key_exists('individual_achievements', $entrant)) :?>
                        <?php echo implode(', ', array_map(function($individual_achievement)
                        { return $individual_achievement['individual_achievement_name'].' - '. $individual_achievement['ball'];}, $entrant['individual_achievements'])); ?>
                    <?php endif; ?>
                    </td>
                    <td><?= $entrant['sum_of_individual']?></td>
                    <td><?= $entrant['original_status_id'] ? 'оригинал': 'копия'?></td>
                    <td><?= $entrant['zos_status_id'] ? '+': '-'?></td>
                    <?php if($cg->isTarget()) : ?>
                    <td><?= $entrant['target_organization_name'] ?></td>
                    <?php endif; ?>
                    <?php if($model->isBvi()):?>
                        <td><?= $entrant['bvi_right'] ?></td>
                    <?php endif; ?>
                    <td><?= $entrant['hostel_need_status_id'] ? 'Да': 'Нет'?></td>
                    <?php if($cg->isContractCg()) : ?>
                        <td><?= $entrant['payment_status'] ? 'Да': 'Нет'?></td>
                    <?php endif; ?>
                    <td><?= key_exists('pp_status_id',$entrant) ? "ПП" : ''?></td>
                    <td><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
                <?php endforeach; ?>
                </tr>
            </table>
            <?php else: ?>
                <h4 style="color: red">в списке нет ни одного абитуриента</h4>
            <?php endif; ?>
        </div>
    </div>