<?php

/** @var $data array */
/** @var $this \yii\web\View*/
/** @var $model modules\dictionary\models\CompetitionList */
/** @var $rcl modules\dictionary\models\RegisterCompetitionList */
/** @var $entrantSetting modules\dictionary\models\SettingEntrant */
use modules\entrant\helpers\DateFormatHelper;

$rcl = $model->registerCompetitionList;
$entrantSetting = $rcl->settingEntrant;
$this->title = $rcl->faculty->full_name.". ".$rcl->speciality->codeWithName;
?>
<div class="row">
    <div class="col-md-12">
        <p>
            Федеральное государственное бюджетное образовательное учреждение высшего образования
            "Московский педагогический государственный университет" <br/>
            учебный год <?= $data['year']?>,<br/>
            дата публикации списка и время обновления <?= DateFormatHelper::format($data['date_time'], 'd.m.Y. H:i')?><br/>
            категория поступающих <?= $model->getTypeName($entrantSetting->special_right) ?>,<br/>
            Структурное подразделение: <?= $rcl->faculty->full_name ?>,<br/>
            направление подготовки <?= $rcl->speciality->codeWithName ?>,<br/>
            уровень образования <?= $entrantSetting->eduLevelFull ?>,<br/>
            форма обучения <?= $entrantSetting->formEdu ?>,<br/>
            вид финансирования <?= $entrantSetting->financeEdu ?>,<br/>
            <?php if( $entrantSetting->isContract()) :?>
            стоимость обучения <?= key_exists('price_per_semester', $data) ? $data['price_per_semester'] : ''  ?> <br/>
            <?php endif; ?>
            <?php if ($entrantSetting->isBudget()) : ?>
                контрольные цифры приема:
                <?php if (is_null($entrantSetting->special_right)) : ?>
                    <?= $data['kcp']['sum'] ?>,
                    целевые - <?= $data['kcp']['target'] ?>
                <?php elseif ($entrantSetting->isTarget()): ?>
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
                    <th>Уникальный номер/СНИЛС</th>
                    <th>Направленность</th>
                    <th>Сумма баллов</th>
                    <?php foreach ($rcl->cgFacultyAndSpeciality->getExaminationsAisId() as $value) : ?>
                        <th><?= $value ?></th>
                    <?php endforeach; ?>
                    <th>Сумма баллов за все предметы ВИ</th>
                    <th>Индивидуальные достижения</th>
                    <th>Сумма баллов за все ИД</th>
                    <th>Подача документа об образовании</th>
                    <th>Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <?php if($entrantSetting->isTarget()) : ?>
                        <th>Наименование целевой организации</th>
                    <?php endif; ?>
                    <th>Нуждается в общежитии</th>
                    <?php if($entrantSetting->isContract()) : ?>
                        <th>Оплатил ?</th>
                    <?php endif; ?>
                    <th>Примечание</th>
                    <th>Дата приема заявлений</th>
                </tr>
                <?php $i=1; foreach ($data[$model->type] as $entrant): ?>
                    <tr <?= !Yii::$app->user->getIsGuest() && Yii::$app->user->identity->incomingId() == $entrant['incoming_id'] ? 'class="success"': ''  ?>">
                    <td><?=$i++?></td>
                    <td><?= key_exists('snils', $entrant)  && $entrant['snils'] ? $entrant['snils'] : $entrant['incoming_id']?></td>
                    <td><?= $entrant['specialization_name'] ?></td>
                    <td><?= $entrant['total_sum']?></td>
                    <?php foreach ($rcl->cgFacultyAndSpeciality->getExaminationsAisId() as $aisKey => $value) :
                        $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                        $subject = $entrant['subjects'][$key]; ?>
                        <td>
                            <?php if(is_int($key)):?>
                                <?= (key_exists('ball', $subject) && $subject['ball'] ? $subject['ball'].", " : '') ?>
                                <?= 'ВИ' ?>
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
                    <?php if($entrantSetting->isTarget()) : ?>
                        <td><?= $entrant['target_organization_name'] ?></td>
                    <?php endif; ?>
                    <td><?= $entrant['hostel_need_status_id'] ? 'Да': 'Нет'?></td>
                    <?php if($entrantSetting->isContract()) : ?>
                        <td><?= $entrant['payment_status'] ? 'Да': 'Нет'?></td>
                    <?php endif; ?>
                    <td><?= key_exists('pp_status_id',$entrant) &&  $entrant['pp_status_id'] ? "ПП" : ''?></td>
                    <td><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
                <?php endforeach; ?>
                </tr>
            </table>
        <?php else: ?>
            <h4>в списке нет ни одного абитуриент</h4>
        <?php endif; ?>
    </div>
</div>
