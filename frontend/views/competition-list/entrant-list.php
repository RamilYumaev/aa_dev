<?php

/** @var $cg dictionary\models\DictCompetitiveGroup */
/** @var $type integer */
/** @var $dates array */
/** @var $date string */
/** @var $id integer */
/** @var $aisId integer */
/** @var $isFilial boolean */
/** @var $eduLevel $eduLevel */
/** @var $special */
/** @var $formEdu */
/** @var $speciality */
/** @var $finance */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\models\CompetitionList;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $rCls */
/* @var $type */
/* @var $rcl modules\dictionary\models\RegisterCompetitionList */
/* @var $cl modules\dictionary\models\CompetitionList */
$jsonDates = json_encode($dates);
$graduateLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
$isGraduate = $eduLevel == $graduateLevel;
$url = \yii\helpers\Url::to($isGraduate ?
    ['entrant-graduate-list',
        'faculty' => $faculty,
        'speciality' => $speciality,
        'special' => $special,
        'form' => $formEdu,
        'finance' => $finance,
        'type'=>$type]:
    ['entrant-list', 'cg'=> $aisId, 'type'=> $type]);
$array = CompetitionList::listTitle($isFilial)[$eduLevel];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competition-list/index']];
$this->params['breadcrumbs'][] = ['label' => $array['name'], 'url' => ['competition-list/'.$array['url']]];
$this->params['breadcrumbs'][] = ['label' => \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty], 'url' => ['competition-list/'.$array['url'], 'faculty' => $faculty]];
$this->params['breadcrumbs'][] = $this->title;
$countRCls = count($rCls);?>
<?php Pjax::begin(['id' => 'competition-list']); ?>
<div class="container" style="position: relative">
    <div class="row">
    <div class="col-md-3 mt-30">
        <?php if(!Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant')): ?>
        <div style="text-align: center">
            <?= DatePicker::widget([
                'name' => 'dp_addon_1',
                'language' => 'ru',
                'value' => $date ??  '',
                'type' => DatePicker::TYPE_INLINE,
                'options' => ['placeholder' => 'Выберите дату', 'id'=>'date'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' =>  'yyyy-mm-dd',
                    'beforeShowDay'=> new \yii\web\JsExpression('function(d) {
                                     var availableDates =  Object.values('.$jsonDates.');
                                        var ymd = d.getFullYear();
                                         ymd+= "-"; 
                                         var m = (d.getMonth()+1); 
                                        if(d.getMonth()<9) { ymd+="0"+m;}  else {
                                         ymd+=""+m;
                                        }
                                         ymd+= "-"; 
                                         var date = d.getDate();
                                        if(d.getDate()<10) {ymd+="0"+date;}  else {ymd+=""+date;}
                                        if ($.inArray(ymd, availableDates) != -1) {
                                            return true; 
                                        } else{
                                             return false; 
                                        }
                                    }'),
                ],'pluginEvents' => [
                    "changeDate" => "function(e) {
              var d = e.date;
              var ymd = d.getFullYear();
                                         ymd+= \"-\"; 
                                         var m = (d.getMonth()+1); 
                                        if(d.getMonth()<9) { ymd+=\"0\"+m;}  else {
                                         ymd+=\"\"+m;
                                        }
                                         ymd+= \"-\"; 
                                         var date = d.getDate();
                                        if(d.getDate()<10) {ymd+=\"0\"+date;}  else {ymd+=\"\"+date;}
                                        console.log(ymd);
                                         $.pjax.reload('#competition-list',{
                      'url': '".$url."&date='+ymd,
                     
                })
                    }",
                ]]) ?>
        <?php endif; ?>
        <?php foreach ($rCls as $index => $rcl) : $cls = $rcl->getCompetitionList()->andWhere(['type'=> $type])->all(); ?>
            <?php foreach ($cls as $cl): $idLast = $cl->id ?>
                <?= Html::a(++$index, $isGraduate ? ['entrant-graduate-list',
                    'faculty' => $rcl->faculty_id,
                    'speciality' => $rcl->speciality_id,
                    'special' => $rcl->settingEntrant->special_right,
                    'form' => $rcl->settingEntrant->form_edu,
                    'finance' => $rcl->settingEntrant->finance_edu,
                    'type'=>$type,
                    'date' =>$rcl->date,
                    'id'=> $cl->id] : ['entrant-list', 'cg'=> $rcl->ais_cg_id, 'type'=>$type, 'date' =>$rcl->date, 'id'=> $cl->id],
                    ['class'=> $idLast == $id || (!$id && $countRCls == $index) ? 'btn btn-warning' :'btn btn-info']) ?>
            <?php endforeach;?>
        <?php endforeach;?>
            <br />
            <?php if(!Yii::$app->user->getIsGuest() && Yii::$app->user->can('entrant')): ?>
                <?= Html::a('Скачать Excel',['export-competition-list/table-file', 'id' => $id ?? $idLast ], ['class'=> 'btn btn-success', 'data-method'=> 'post', 'target'=>'_blank', 'style' => ["margin-top"=> "5px"]]) ?>
            <?php endif; ?>
        </div>
    </div

        <?= \frontend\widgets\competitive\CompetitiveListWidget::widget(['view' => $isGraduate ? 'list-one-graduate' : 'list-one','id'=>$id ?? $idLast]);?>
</div>
</div>
<?php Pjax::end(); ?>
