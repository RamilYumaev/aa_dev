<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\entrant\helpers\BlockRedGreenHelper;

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */

?>
<div class="box box-widget widget-user-2">
    <div class="widget-user-header bg-gray">
        <div class="widget-user-image">
        </div>
        <h3 class="widget-user-username"><?= $profile->last_name . " " . $profile->first_name . " " . $profile->patronymic; ?></h3>
        <h5 class="widget-user-desc"><?= $profile->phone; ?></h5>
        <h5 class="widget-user-desc"><?= $profile->user->email; ?></h5>
    </div>
    <div class="box-footer no-padding">
        <table class="table">
            <tbody><tr>
                <th style="width:50%"><?= $profile->getAttributeLabel('gender') ?></th>
                <td><?= $profile->genderName ?></td>
            </tr>
            <tr>
                <th><?= $profile->getAttributeLabel('country_id') ?></th>
                <td><?= $profile->countryName ?></td>
            </tr>
            <?php if(!$profile->isNoRussia()): ?>
                <tr>
                    <th><?= $profile->getAttributeLabel('region_id') ?></th>
                    <td><span class="badge bg-blue"><?= $profile->regionName ?></span></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>