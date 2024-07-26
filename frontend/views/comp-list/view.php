<?php
/**
 * @var $this View
 * @var $faculty
 * @var $data array
 * @var $types array
 */

use frontend\widgets\competitive\ButtonEpkWidget;
use yii\web\View;
$this->title = $faculty->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['comp-list/index']];
$this->params['breadcrumbs'][] = $this->title;

$levels = array_unique(array_column($data, 'education_level'));
?>

<div class="container">
    <div class="row">
        <div class=" col-xs-offset-1 col-xs-10 col-md-offset-3 col-md-6">
        <h3 style="margin-top: 54px; text-align: center"><?= $this->title ?></h3>
            <div style="margin: 0 auto; margin-top: 30px;">
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($levels as $level) {
               $cgCroup = array_filter($data, function ($d) use ($level) {
                   return $d['education_level'] == $level;
               })?>
        <h4><?= $level ?></h4>
        <table class="table">
            <tr>
                <th style="width: 760px">Код и наименование направления подготовки</th>
                <th>Форма обучения</th>
                <th>Конкурсные списки</th>
            </tr>
            <?php foreach ($cgCroup as $cg):
                $typesFilter = array_filter($types, function ($type) use($cg) {
                    return $type['code_spec'] == $cg['code_spec'] &&
                    $type['speciality'] ==  $cg['speciality'] &&
                        $type['profile'] == $cg['profile']  &&
                        $type['education_form'] == $cg['education_form']  &&
                        $type['education_level'] == $cg['education_level'];
                }) ?>
                <tr>
                    <td style="font-weight: 100"><?= $cg['code_spec']?> - <?= $cg['speciality']?>, <?= $cg['profile'] ?></td>
                    <td style="font-weight: 100"><?= $cg['education_form'] ?></td>
                    <td style="font-weight: 100"><?= ButtonEpkWidget::widget(['types' => $typesFilter]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php } ?>
    </div>
</div>


