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
            стоимость обучения <?= $data['price_per_semester'] ?> <br/>
            <?php endif; ?>
            контрольные цифры приема:
            <?= $data['kcp']['sum'] ?>,
            Квота <?= $data['kcp']['quota'] ?>,
            Целевые <?= $data['kcp']['target'] ?>,
            <?= $data['kcp']['transferred'] ?>,<br/>
        </p>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <?php if(key_exists($model->type, $data)):?>
            <table class="table table">
                <tr>
                    <th>№ п/п</th>
                    <th>СНИЛС</th>
                    <th>Направленность</th>
                    <th>Сумма баллов</th>
                    <?php foreach ($rcl->cgFacultyAndSpeciality->getExaminationsAisId() as $value) : ?>
                        <th><?= $value ?></th>
                    <?php endforeach; ?>
                    <th>Индивидуальные достижения</th>
                    <th>Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <th>Нуждается в общежитии</th>
                    <th>Примечание</th>
                    <th>Дата приема заявлений</th>
                </tr>
                <?php $i=1; foreach ($data[$model->type] as $entrant): ?>
                <tr>
                    <td><?=$i++?></td>
                    <td><?=$entrant['snils']?></td>
                    <td><?= $entrant['specialization_name'] ?></td>
                    <td><?= $entrant['total_sum']?></td>
                    <?php foreach ($rcl->cgFacultyAndSpeciality->getExaminationsAisId() as $aisKey => $value) :
                        $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                        $subject = $entrant['subjects'][$key]; ?>
                        <td><?= is_int($key) ? $subject['ball']. ($subject['subject_type'] == 1 ? ($subject['check_status'] == 1 ?', проверено':", не проверено"):"") :""?></td>
                    <?php endforeach; ?>
                    <td>
                    <?php if(key_exists('individual_achievements', $entrant)) :?>
                        <?php echo implode(', ', array_map(function($individual_achievement)
                        { return $individual_achievement['individual_achievement_name'].' - '. $individual_achievement['ball'];}, $entrant['individual_achievements'])); ?>
                    <?php endif; ?>
                    </td>
                    <td><?= $entrant['zos'] ? '+': '-'?></td>
                    <td><?= $entrant['hostel_need_status'] ? 'Да': 'Нет'?></td>
                    <td><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
                <?php endforeach; ?>
                </tr>
            </table>
            <?php else: ?>
                <h4>в списке нет ни одного абитуриент</h4>
            <?php endif; ?>
        </div>
    </div>