<?php

/** @var $data array */
/** @var $this \yii\web\View*/
/** @var $model modules\dictionary\models\CompetitionList */
/** @var $cg dictionary\models\DictCompetitiveGroup */
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\ConverterBasicExam;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\UserAis;
use yii\helpers\Html;

$cg = $model->registerCompetitionList->cg;
$this->title =$cg->specialty->codeWithName ."/". $cg->getEduLevel()."/".$cg->getSpecialisationName().'/'.$cg->getSpecialisationName()."/".$cg->formEdu;
$subjectType = [1 => 'ЕГЭ', 2 => 'ЦТ', 3 => 'ВИ', 4 => 'СБА'];
$subjectStatus =[ 1 => 'не проверено', 2 => 'проверено', 3 => 'ниже минимума' , 4 => 'истек срок'];
$aisCseIdCg = $cg->getExaminationsCseAisId();
$aisCtIdCg = $cg->getExaminationsCtAisId();
$examinations = $cg->getExaminationsAisId();
$compositeId = $cg->getCompositeDisciplineId();
$selectDiscipline =\dictionary\models\CompositeDiscipline::getOne($compositeId);
$noGuest =!Yii::$app->user->getIsGuest();
$incomingId = $noGuest ? Yii::$app->user->identity->incomingId() : '';
$basicExam = ConverterBasicExam::getCompositeDisciplines();
$isEntrant = !Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant');
?>

<div class=" col-offset-md-3 col-md-9" >
    <p style="font-size: 15px; margin-top: 30px">
        <span style="display: block; text-align: center">
            ФГБОУ ВО
            "Московский педагогический государственный университет" <br/>
            Учебный год 2024/2025<br/><br/><br/>
            </span>
        <?php if($cg->isSpecQuota()): ?>
        <span style="font-weight: bold"> «Специальная квота в соответствии с Указом Президента РФ №268 от 09.05.2022г.».</span>
        <?php endif; ?>
        <span style="font-weight: bold"> Дата публикации списка и время обновления: </span><?= DateFormatHelper::format($model->datetime, 'd.m.Y. H:i')?><br/>
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
                <?php /* if(!$model->registerCompetitionList->settingCompetitionList->isEndDateZuk() || ($model->registerCompetitionList->settingCompetitionList->isEndDateZuk()
          && $model->registerCompetitionList->settingEntrant->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER)) : */ ?>
                    <?= $data['kcp']['sum'] ?>,
                    из них:
                    <?php if($model->registerCompetitionList->settingEntrant->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) :?>
                        особая квота - <?= $data['kcp']['quota'] ?>,
                        спецквота - <?= $data['kcp']['z'] ?>,
                    <?php endif; ?>
                    целевая квота - <?= $data['kcp']['target'] ?>
                <?php /* else: */ ?>
                    <?php /*$data['kcp']['sum'] */ ?>
                <?php /* endif; */ ?>
            <?php elseif ($cg->isKvota()): ?>
                <?= $data['kcp']['quota'] ?>,
            <?php elseif ($cg->isTarget()): ?>
                <?=  $data['kcp']['target']  ?>,
            <?php elseif ($cg->isSpecQuota()): ?>
                <?=  $data['kcp']['z']  ?>,
            <?php endif; ?> <br/>
            <?php if($data['kcp']['transferred']) : ?>
                <span style="font-weight: bold">Ранее зачислено:</span> <?= $data['kcp']['transferred'] ?> <br/>
            <?php endif; ?>
        <?php endif; ?>
    </p>
</div>
<?php if($model->isBvi()) :?>
<!--    <h4 style="color: red">Прием заявлений о согласии на зачисление окончен</h4>-->
<?php else:?>
    <?php if(!$model->registerCompetitionList->settingEntrant->open()) :?>
        <h4 style="color: red">Прием заявлений о согласии на зачисление окончен</h4>
    <?php endif;?>
<?php endif;?>
</div>
<div style="margin-top: 80px">
    <?php if(key_exists($model->type, $data) && count($data[$model->type])):
        foreach ($data[$model->type] as $list => $value) {
            foreach ($value['subjects'] as $key => $subject) {
                if($subject['subject_type_id'] == 1) {
                    $aisCseId = $aisCseIdCg[$subject['subject_id']];
                    if(key_exists($aisCseId,$selectDiscipline)) {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $selectDiscipline[$aisCseId];
                        foreach ($examinations as $aisId => $examination) {
                            if(key_exists($aisId, $basicExam)) {
                                if($basicExam[$aisId][0] == $selectDiscipline[$aisCseId]) {
                                    $data['list'][$list]['subjects'][$key]['subject_id'] = $aisId;
                                }
                            }
                        }
                    } else {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $aisCseId;
                        foreach ($examinations as $aisId => $examination) {
                            if(key_exists($aisId, $basicExam)) {
                                if($basicExam[$aisId][0] == $aisCseId) {
                                    $data['list'][$list]['subjects'][$key]['subject_id'] = $aisId;
                                }
                            }
                        }
                    }
                }elseif($subject['subject_type_id'] == 2)  {
                    $aisCtId = $aisCtIdCg[$subject['subject_id']];
                    if(key_exists($aisCtId,$selectDiscipline)) {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $selectDiscipline[$aisCtId];
                        foreach ($examinations as $aisId => $examination) {
                            if(key_exists($aisId, $basicExam)) {
                                if($basicExam[$aisId][0] == $selectDiscipline[$aisCtId]) {
                                    $data['list'][$list]['subjects'][$key]['subject_id'] = $aisId;
                                }
                            }
                        }
                    } else {
                        $data['list'][$list]['subjects'][$key]['subject_id'] =  $aisCtId;
                        foreach ($examinations as $aisId => $examination) {
                            if(key_exists($aisId, $basicExam)) {
                                if($basicExam[$aisId][0] == $aisCtId) {
                                    $data['list'][$list]['subjects'][$key]['subject_id'] = $aisId;
                                }
                            }
                        }
                    }
                }
            }
        }
        ?>
        <center style="font-size: 18px"><?= Html::a('Расшифровки аббревиатур в конкурсных списках', ['list-short'])?></center>
        <?php if($cg->isSpecQuota()):
        $result = function ($type) use($data, $model) {
            return array_filter($data[$model->type], function ($v) use($type) {
                $incoming = UserAis::findOne(['incoming_id' => $v['incoming_id']]);
                return $incoming &&  OtherDocument::findOne(['user_id' => $incoming->user_id,
                    'exemption_id' => \modules\entrant\helpers\OtherDocumentHelper::SPECIAL_QUOTA,  "reception_quota" => $type]);
            });
        };?>
            <?= $this->render('list_spec', ['bvi' => true,
            'examinations' => $examinations,
            'isEntrant' => $isEntrant,
            'incomingId' => $incomingId,
            'data' => $result(2),
        ])?>
        <?= $this->render('list_spec', ['bvi' => false,
            'examinations' => $examinations,
            'isEntrant' => $isEntrant,
            'incomingId' => $incomingId,
            'subjectType' => $subjectType,
            'subjectStatus' => $subjectStatus,
            'data' => $result(1),
        ])?>
        <?php else : ?>
        <?php if(!$cg->isBudget()) : ?>
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
                    <th style="font-size: 12px; text-align: center">Подача документа об образовании</th>
                    <?php if(!$cg->isSpo()) :?>
                        <th style="font-size: 12px; text-align: center">Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <?php endif; ?>
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
                    <th style="font-size: 12px; text-align: center">Индивидуальные достижения</th>
                    <th style="font-size: 12px; text-align: center">Сумма баллов</th>
                    <?php if($model->registerCompetitionList->settingEntrant->edu_level != DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER) :?>
                        <th style="font-size: 12px; text-align: center">Примечание</th>
                    <?php endif; ?>
                    <th style="font-size: 12px; text-align: center">Дата приема заявлений</th>
                </tr>
                <?php  $i=1; foreach ($data[$model->type] as $entrant): ?>
                <tr <?=  $incomingId == $entrant['incoming_id'] ? 'class="success"': ''  ?> >
                    <td style="font-size: 14px; text-align: center"><?=$i++?></td>
                    <td style="font-size: 14px; text-align: center"><?=  $cg->isSpecQuota() ? $entrant['incoming_id'] : (key_exists('snils', $entrant) ? ($entrant['snils'] ? $entrant['snils'] : $entrant['incoming_id']) : $entrant['incoming_id']) ?></td>
                    <?php if($isEntrant): ?>
                        <td style="font-size: 14px; text-align: center"> <?= $entrant['last_name']." ". $entrant['first_name']." ". $entrant['patronymic'] ?></td>
                        <td style="font-size: 14px; text-align: center"> <?= key_exists('phone',$entrant) ? $entrant['phone'] : '-' ?></td>
                    <?php endif; ?>
                    <?php foreach ($examinations as $aisKey => $value) :
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

                    <td style="font-size: 14px; text-align: center"><?=  $entrant['original_status_id'] ? 'оригинал': 'копия'  ?></td>
                    <?php if(!$cg->isSpo()) :?>
                        <td style="font-size: 14px; text-align: center">
                            <?php if($entrant['zos_status_id']===0) : ?>
                                -
                            <?php elseif( $entrant['zos_status_id']===1) : ?>
                                +
                            <?php elseif($entrant['zos_status_id']===2): ?>
                                др.н.п
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
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
                    <td style="font-size: 14px; text-align: center">
                        <?php if(key_exists('individual_achievements', $entrant)) :?>
                            <?php echo implode(', ', array_map(function($individual_achievement)
                            { return $individual_achievement['individual_achievement_name'];}, $entrant['individual_achievements'])); ?>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 14px; text-align: center"><?= $entrant['total_sum']?></td>
                    <?php if($model->registerCompetitionList->settingEntrant->edu_level != DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER) :?>
                        <td style="font-size: 14px; text-align: center"><?= key_exists('pp_status_id',$entrant) && $entrant['pp_status_id'] ? "ПП" : ''?>
                            <?= key_exists('fp_status_id',$entrant) && $entrant['fp_status_id'] ? "1-приём" : ''?>
                        </td>
                    <?php endif; ?>
                    <td style="font-size: 14px; text-align: center"><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <h4 style="color: red">В списке нет ни одного абитуриента</h4>
    <?php endif; ?>
</div>