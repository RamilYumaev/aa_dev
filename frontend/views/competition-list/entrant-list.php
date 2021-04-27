<?php

/** @var $cg dictionary\models\DictCompetitiveGroup */
/** @var $type integer */
/** @var $dates array */
/** @var $date string */
/** @var $id integer */

use modules\dictionary\models\CompetitionList;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $rCls */
/* @var $type */
/* @var $rcl modules\dictionary\models\RegisterCompetitionList */
/* @var $cl modules\dictionary\models\CompetitionList */
$jsonDates = json_encode($dates);
$this->title = $cg->getFullNameCg();
$url = \yii\helpers\Url::to(['entrant-list', 'cg'=> $cg->ais_id, 'type'=> $type]);
$array = CompetitionList::listTitle($cg->faculty->filial)[$cg->edu_level];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competition-list/index']];
$this->params['breadcrumbs'][] = ['label' => $array['name'], 'url' => ['competition-list/'.$array['url']]];
$this->params['breadcrumbs'][] = $this->title;
$countRCls = count($rCls);?>
<?php Pjax::begin(['id' => 'competition-list']); ?>
<div class="row">
    <div class="col-md-3">
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
        <?php foreach ($rCls as $index => $rcl) : $cls = $rcl->getCompetitionList()->andWhere(['type'=> $type])->all(); ?>
            <?php foreach ($cls as $cl): $idLast = $cl->id ?>
                <?= Html::a(++$index,['entrant-list', 'cg'=> $cl->ais_cg_id, 'type'=>$type, 'date' =>$rcl->date, 'id'=> $cl->id],
                    ['class'=> $idLast == $id || (!$id && $countRCls == $index) ? 'btn btn-warning' :'btn btn-info']) ?>
            <?php endforeach;?>
        <?php endforeach;?>
    </div>
    <div class="col-md-9">
        <?= \frontend\widgets\competitive\CompetitiveListWidget::widget(['id'=>$id ?? $idLast]);?>
    </div>
</div>
<?php Pjax::end(); ?>