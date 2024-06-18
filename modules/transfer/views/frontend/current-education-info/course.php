<?php
/* @var $cg \dictionary\models\DictCompetitiveGroup*/
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin();
$result = date("Y") - $cg->yearConverter()[1] - (date("n") > 10  && date("n") <= 12  ? 0 : 0);
$class = \dictionary\helpers\DictClassHelper::getListTransfer($cg->edu_level);
$classFlip = array_values(array_flip($class));
$arraySliceClass =array_slice($classFlip, 0, $result+1);
    function array_slice_keys($array, $keys = null) {
        if ( empty($keys) ) {
            $keys = array_keys($array);
        }
        if ( !is_array($keys) ) {
            $keys = array($keys);
        }
        if ( !is_array($array) ) {
            return array();
        } else {
            return array_intersect_key($array, array_fill_keys($keys, '1'));
        }
    }

    $data = array_slice_keys($class, $arraySliceClass);
    $numberMonth  = (int) date("n");
    $isSummer = $numberMonth > 5 && $numberMonth < 9;
    $countSemester = 0;

if ($isSummer)  {
    foreach ($data as $key  => $datum) {
        unset($data[$key]);
        break;
    }
    $countSemester = (count($data)+1)*2;

} else {
    $countSemester =  (count($data)*2);
}
    $semester = [];
    for ($i = 1; $i <= $countSemester; $i++) {
        if($i == 1 && $isSummer) {
            continue;
        }

        if($isSummer && ($i % 2 == 1)) {
            $semester[$i] = $i;
        }
        if(!$isSummer && ($i % 2 == 0)) {
            $semester[$i] = $i;
        }
    }
    ?>
<div>
    <h4><?= $cg->yearConverter()[1]."".$cg->getFullNameCg()?></h4>
    <label>Курс</label>
    <?= Html::dropDownList('course', '', $data,['class'=> 'form-control']) ?><br/>
    <label>Семестр</label>
    <?= Html::dropDownList('semester', '', $semester,['class'=> 'form-control']) ?><br/>
    <label>Образование</label>
    <?= Html::dropDownList('edu_count', '', (new \modules\transfer\models\CurrentEducation())->listEdu(),['class'=> 'form-control']) ?>
</div>
<br/>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>