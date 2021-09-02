<?php

/** @var $data array */
/** @var $this \yii\web\View*/
/** @var $model modules\dictionary\models\CompetitionList */
/** @var $rcl modules\dictionary\models\RegisterCompetitionList */
/** @var $entrantSetting modules\dictionary\models\SettingEntrant */
use modules\entrant\helpers\DateFormatHelper;
use yii\helpers\Html;

$rcl = $model->registerCompetitionList;
$entrantSetting = $rcl->settingEntrant;
$this->title = $rcl->faculty->full_name.". ".$rcl->speciality->codeWithName;
?>
<div class=" col-offset-md-3 col-md-9" >
        <p style="font-size: 15px; margin-top: 30px">
        <span style="display: block; text-align: center">
             ФГБОУ ВО
            "Московский педагогический государственный университет" <br/>
            Учебный год 2021/2022<br/><br/><br/>
            </span>
            <span style="font-weight: bold"> Дата публикации списка и время обновления: </span> <?= DateFormatHelper::format($data['date_time'], 'd.m.Y. H:i')?><br/>
            <span style="font-weight: bold">Категория поступающих: </span> <?= $model->getTypeName($entrantSetting->special_right) ?>,<br/>
            <span style="font-weight: bold">Структурное подразделение: </span> <?= $rcl->faculty->full_name ?>,<br/>
            <span style="font-weight: bold">Направление подготовки: </span> <?= $rcl->speciality->codeWithName ?>,<br/>
            <span style="font-weight: bold">Уровень образования: </span> <?= $entrantSetting->eduLevelFull ?>,<br/>
            <span style="font-weight: bold">Форма обучения: </span> <?= $entrantSetting->formEdu ?>,<br/>
            <span style="font-weight: bold">Вид финансирования: </span> <?= $entrantSetting->financeEdu ?>,<br/>
            <?php if( $entrantSetting->isContract()) :?>
            <span style="font-weight: bold">Стоимость обучения:  </span> <?= key_exists('price_per_semester', $data['kcp']) ? $data['kcp']['price_per_semester'] . ' руб. за семестр' : '' ?> <br/>
            <?php endif; ?>
            <?php if($data['kcp']['transferred']) : ?>
                <span style="font-weight: bold">Ранее зачислено:</span> <?= $data['kcp']['transferred'] ?> <br/>
            <?php endif; ?>
            <?php if ($entrantSetting->isBudget()) : ?>
                <span style="font-weight: bold">Контрольные цифры приема:</span>
                <?php if (is_null($entrantSetting->special_right)) : ?>
                
                    <?= $data['kcp']['sum'] ?>,
                    из них: 
                    целевая квота - <?= $data['kcp']['target'] ?>
                <?php elseif ($entrantSetting->isTarget()): ?>
                    <?=  $data['kcp']['target']  ?>,
                <?php endif; ?>
                <?php /* $data['kcp']['transferred'] ?? '' */ ?><br/>
            <?php endif; ?>
        </p>
    </div>
</div>
    <div style="margin-top: 80px">
            <?php if(key_exists($model->type, $data) && count($data[$model->type])):
                foreach ($data[$model->type] as $list => $value) {
                    foreach ($value['subjects'] as $key => $subject) {
                        $isSpec = \dictionary\models\DictDiscipline::find()->andWhere(['ais_id' =>$subject['subject_id']])
                            ->andWhere(['like','name','Специальная дисциплина'])->exists();
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $isSpec ? 0 : $subject['subject_id'];
                    }
                }
                ?>
                <center style="font-size: 18px"><?= Html::a('Расшифровки аббревиатур в конкурсных списках', ['list-short'])?></center>
            <div class="table-responsive">
            <table class="table">
                <tr>
                    <th style="font-size: 12px; text-align: center">№ п/п</th>
                    <th style="font-size: 12px; text-align: center">Уникальный номер/СНИЛС</th>
                    <?php if(!Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant')): ?>
                        <th style="font-size: 12px; text-align: center">Фамилия Имя Отчество</th>
                    <?php endif; ?>
                    <th>Направленность</th>
                    
                    <?php foreach ($rcl->cgFacultyAndSpeciality->getExaminationsGraduateAisId() as $value) : ?>

                        <th><?= $value ?></th>
                    <?php endforeach; ?>
                    <th style="font-size: 12px; text-align: center">Сумма баллов за все предметы ВИ</th>
                    <th style="font-size: 12px; text-align: center">Индивидуальные достижения</th>
                    <th style="font-size: 12px; text-align: center">Сумма баллов за все ИД</th>
                  <!--  <th>Подача документа об образовании</th> -->
                    <th style="font-size: 12px; text-align: center">Согласие на зачисление подано (+) / отсутствует (-)</th>
                    <?php if($entrantSetting->isTarget()) : ?>
                        <th style="font-size: 12px; text-align: center">Наименование целевой организации</th>
                    <?php endif; ?>
                    <th style="font-size: 12px; text-align: center">Нуждается в общежитии</th>
                    <?php if($entrantSetting->isContract()) : ?>
                        <th style="font-size: 12px; text-align: center">Оплатил ?</th>
                    <?php endif; ?>
                    <th>Сумма баллов</th>
                    <th>Примечание</th>
                    <th>Дата приема заявлений</th>

                </tr>
                <?php $i=1; foreach ($data[$model->type] as $entrant): ?>
                    <tr <?= !Yii::$app->user->getIsGuest() && Yii::$app->user->identity->incomingId() == $entrant['incoming_id'] ? 'class="success"': ''  ?>">
                    <td style="font-size: 14px; text-align: center"><?=$i++?></td>
                    <td style="font-size: 14px; text-align: center"><?= key_exists('snils', $entrant)  && $entrant['snils'] ? $entrant['snils'] : $entrant['incoming_id']?></td>
                    <?php if(!Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant')): ?>
                        <td style="font-size: 14px; text-align: center"> <?= $entrant['last_name']." ". $entrant['first_name']." ". $entrant['patronymic'] ?></td>
                    <?php endif; ?>
                    <td><?= $entrant['specialization_name'] ?></td>
                    
                    <?php foreach ($rcl->cgFacultyAndSpeciality->getExaminationsGraduateAisId() as $aisKey => $value) :
                        $key = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                        $subject = $entrant['subjects'][$key]; ?>
                        <td style="font-size: 14px; text-align: center">
                            <?php if(is_int($key)):?>
                                <?= (key_exists('ball', $subject) && $subject['ball'] ? $subject['ball'].", " : '') ?>
                                <?= 'ВИ' ?>
                            <?php endif; ?>
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
                    <!--<td><?php /* $entrant['original_status_id'] ? 'оригинал': 'копия' */ ?></td> -->
                    <td style="font-size: 14px; text-align: center"><?= $entrant['zos_status_id'] ? '+': '-'?></td>
                    <?php if($entrantSetting->isTarget()) : ?>
                        <td><?= $entrant['target_organization_name'] ?></td>
                    <?php endif; ?>
                    <td style="font-size: 14px; text-align: center"><?= $entrant['hostel_need_status_id'] ? 'Да': 'Нет'?></td>
                    <?php if($entrantSetting->isContract()) : ?>
                        <td><?= $entrant['payment_status'] ? 'Да': 'Нет'?></td>
                    <?php endif; ?>
                    <td><?= $entrant['total_sum']?></td>
                    <td><?= key_exists('pp_status_id',$entrant) &&  $entrant['pp_status_id'] ? "ПП" : ''?></td>

                    <td><?= DateFormatHelper::format($entrant['incoming_date'] , 'd.m.Y') ?></td>
                <?php endforeach; ?>
                </tr>
            </table>
            </div>
        <?php else: ?>
            <h4 style="color: red">В списке нет ни одного абитуриента</h4>
        <?php endif; ?>
    </div>
