<?php

use backend\widgets\adminlte\Box;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $anketa modules\entrant\models\AnketaCi*/
/* @var $anketaCg modules\entrant\models\AnketaCiCg*/
/* @var $cg \dictionary\models\DictCompetitiveGroup*/
/* @var $isUserSchool bool */

?>

<?php if ($anketa) : ?>
    <div class="row">
        <div class="col-md-12">
            <table>
                <tr><th>Выбранные конкурсные группы </th></tr>
                <?php foreach ($anketa->anketaCg as $anketaCg): $cg = $anketaCg->cg ?>
                <tr><td><?= $cg->getFullNameCg()?> </td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>