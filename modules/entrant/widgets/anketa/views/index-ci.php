<?php

use backend\widgets\adminlte\Box;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $anketa modules\entrant\models\AnketaCi */
/* @var $isUserSchool bool */

?>
<?php if ($anketa) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="p-30 green-border">
                <table>
                    <tr>
                        <th>ФИО</th>
                        <td><?= $anketa->fio ?></td>
                    </tr>
                    <tr>
                        <th>Телефон</th>
                        <td><?= $anketa->phone ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $anketa->email ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>