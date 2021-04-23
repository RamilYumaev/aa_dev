<?php

/** @var $data array */
/** @var $model modules\dictionary\models\CompetitionList */
/** @var $cg dictionary\models\DictCompetitiveGroup */

$cg = $model->cg;
use modules\entrant\helpers\DateFormatHelper; ?>
<div class="row">
    <div class="col-md-12">
        <p>
            Федеральное государственное бюджетное образовательное учреждение высшего образования
            "Московский педагогический государственный университет" <br/>
            учебный год <?= $data['year']?>,<br/>
            дата публикации списка и время обновления <?= DateFormatHelper::format($data['date'], 'd.m.Y. H:i')?><br/>
            категория поступающих <?= $model->typeName ?>,<br/>
            Структурное подразделение: <?= $cg->faculty->full_name ?>,<br/>
            направление подготовки <?= $cg->specialty->codeWithName ?>,<br/>
            уровень образования <?= $cg->eduLevelFull ?>,<br/>
            профиль(и) <?= $cg->specialisationName ?>,<br/>
            форма обучения <?= $cg->formEdu ?>,<br/>
            вид финансирования <?= $cg->finance ?>,<br/>
            стоимость обучения <?= $data['price_per_semester'] ?> <br/>
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
            <?php if(key_exists('entrants', $data)):?>
            <table class="table table">
                <tr>
                    <th>№ п/п</th>
                    <th>Фамилия Имя Отчество</th>
                    <th>СНИЛС</th>
                    <th>Сумма баллов</th>
                    <?php foreach ($cg->getExaminationsAisId() as $value) : ?>
                        <th><?= $value ?></th>
                    <?php endforeach; ?>
                    <th>Индивидуальные достижения</th>
                    <th>Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <th>Нуждается в общежитии</th>
                    <th>Дата приема заявлений</th>
                </tr>
                <?php $i=1; foreach ($data['entrants'] as $entrant): ?>
                <tr>
                    <td><?=$i++?></td>
                    <td> <?= $entrant['last_name']." ". $entrant['first_name']." ". $entrant['patronymic'] ?></td>
                    <td><?=$entrant['snils']?></td>
                    <td><?= $entrant['total_sum']?></td>
                    <?php foreach ($cg->getExaminationsAisId() as $aisKey => $value) :
                        $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                        $subject = $entrant['subjects'][$key];
                    ?>
                        <td><?= $subject['ball']. ($subject['subject_type'] == 1 ? ($subject['check_status'] == 1 ?', проверено':", не проверено"):"") ?></td>
                    <?php endforeach; ?>
                    <td>
                    <?php if(key_exists('individual_archievments', $entrant)) :?>
                        <?php echo implode(', ', array_map(function($individual_archievment)
                        { return $individual_archievment['name_of_individual_archievment'].' - '. $individual_archievment['ball'];}, $entrant['individual_archievments'])); ?>
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