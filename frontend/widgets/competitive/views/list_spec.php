<?php

/** @var $data array */
/** @var $this \yii\web\View*/
/** @var $model modules\dictionary\models\CompetitionList */
/** @var $cg dictionary\models\DictCompetitiveGroup */
/** @var $bvi boolean */
/** @var $isEntrant  */
/** @var $incomingId */
use modules\entrant\helpers\DateFormatHelper;
?>
<?php if($data) : ?>
<h3 style="margin: 10px; text-align: center"><?= $bvi ?  'Специальная квота согласно подпункту "б"': 'Специальная квота согласно подпункту "а"' ?></h3>
<div class="table-responsive">
    <table class="table" >
        <tr>
            <th style="font-size: 12px; text-align: center">№ п/п</th>
            <th style="font-size: 12px; text-align: center">Уникальный номер/СНИЛС</th>
            <?php if($isEntrant): ?>
                <th style="font-size: 12px; text-align:center">Фамилия Имя Отчество</th>
                <th style="font-size: 12px; text-align:center">Телефон</th>
            <?php endif; ?>
            <?php foreach ($examinations as $value) : ?>
                <th style="font-size: 12px; text-align: center"><?= $value ?></th>
            <?php endforeach; ?>
            <th style="font-size: 12px; text-align: center">Сумма баллов за все предметы ВИ</th>
            <th style="font-size: 12px; text-align: center">Индивидуальные достижения</th>
            <th style="font-size: 12px; text-align: center">Сумма баллов за все ИД</th>
            <th style="font-size: 12px; text-align: center">Подача документа об образовании</th>
            <th style="font-size: 12px; text-align: center">Согласие на зачисление подано (+) / отсутствует (-)</th>
            <th style="font-size: 12px; text-align: center">Нуждается в общежитии</th>
            <th style="font-size: 12px; text-align: center">Сумма баллов</th>
            <th style="font-size: 12px; text-align: center">Прмечание</th>
            <th style="font-size: 12px; text-align: center">Дата приема заявлений</th>
        </tr>
        <?php  $i=1; foreach ($data as $entrant):
        if($bvi &&  $entrant['subject_sum'] != 300) {
            continue;
        }elseif(!$bvi && $entrant['subject_sum'] == 300) {
            continue;
        }
        ?>
        <tr <?=  $incomingId == $entrant['incoming_id'] ? 'class="success"': ''  ?> >
            <td style="font-size: 14px; text-align: center"><?=$i++?></td>
            <td style="font-size: 14px; text-align: center"><?=   $entrant['incoming_id']  ?></td>
            <?php if($isEntrant): ?>
                <td style="font-size: 14px; text-align: center"> <?= $entrant['last_name']." ". $entrant['first_name']." ". $entrant['patronymic'] ?></td>
                <td style="font-size: 14px; text-align: center"> <?= key_exists('phone',$entrant) ? $entrant['phone'] : '-' ?></td>
            <?php endif; ?>
            <?php foreach ($examinations as $aisKey => $value) :
                $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                $subject = $entrant['subjects'][$key];
                ?>
                <td style="font-size: 14px; text-align: center">
                    <?php if($bvi): ?>
                     БВИ
                    <?php else: ?>
                    <?= (key_exists('ball', $subject) && $subject['ball'] ? $subject['ball'].", " : '') ?>
                    <?= $subjectType[$subject['subject_type_id']] ?>
                    <?=  key_exists('check_status_id', $subject) && $subject['check_status_id'] ? ", ".$subjectStatus[$subject['check_status_id']] : ''?>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
            <td style="font-size: 14px; text-align: center"><?= !$bvi ? $entrant['subject_sum'] : "БВИ" ?></td>
            <td style="font-size: 14px; text-align: center">
                <?php if(key_exists('individual_achievements', $entrant)) :?>
                    <?php echo implode(', ', array_map(function($individual_achievement)
                    { return $individual_achievement['individual_achievement_name'].' - '. $individual_achievement['ball'];}, $entrant['individual_achievements'])); ?>
                <?php endif; ?>
            </td>
            <td style="font-size: 14px; text-align: center"><?= $entrant['sum_of_individual']?></td>
            <td style="font-size: 14px; text-align: center"><?=  $entrant['original_status_id'] ? 'оригинал': 'копия'  ?></td>
            <td style="font-size: 14px; text-align: center">
                <?php if($entrant['zos_status_id']===0) : ?>
                    -
                <?php elseif( $entrant['zos_status_id']===1) : ?>
                    +
                <?php elseif($entrant['zos_status_id']===2): ?>
                    др.н.п
                <?php endif; ?>
            </td>
            <td style="font-size: 14px; text-align: center"><?= $entrant['hostel_need_status_id'] ? 'Да': 'Нет'?></td>
            <td style="font-size: 14px; text-align: center"><?= !$bvi ? $entrant['total_sum'] : "БВИ"?></td>
            <td style="font-size: 14px; text-align: center"><?= key_exists('pp_status_id',$entrant) && $entrant['pp_status_id'] ? "ПП" : ''?></td>
            <td style="font-size: 14px; text-align: center"><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
            <?php endforeach; ?>
        </tr>
    </table>
</div>
<?php endif; ?>