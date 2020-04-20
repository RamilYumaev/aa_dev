<?php
/* @var $this yii\web\View */
/* @var $submitted modules\entrant\models\SubmittedDocuments */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <div class="mt-20">
            <?php if($submitted): ?>
                <h4>Ваш способ подачи документов - <?= $submitted->typeName?> </h4>
                <div id="compact">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Факультет</th>
                            <th>Направление подготовки</th>
                            <th>Уровень образования</th>
                            <th>Основание приема</th>
                            <th></th>
                        </tr>
                        <?php foreach ($userCg as $key => $cg) /* @var $cg dictionary\models\DictCompetitiveGroup */ :?>
                            <tr>
                                <td><?= ++$key ?></td>
                                <td><?= $cg->faculty->full_name ?></td>
                                <td><?= $cg->specialty->code." ".$cg->specialty->name ?></td>
                                <td><?= DictCompetitiveGroupHelper::eduLevelName($cg->edu_level) ?></td>
                                <td><?= DictCompetitiveGroupHelper::specialRightName($cg->special_right_id) ?></td>
                                <td><?= Html::a('Скачать', ['post-document/doc', 'faculty' => $cg->faculty_id, 'speciality'=> $cg->speciality_id,
                                        'edu_level' => $cg->edu_level, 'special_right_id'=> $cg->special_right_id ], ['class' => 'btn btn-large btn-primary'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

