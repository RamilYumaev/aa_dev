<?php

use olympic\helpers\OlympicListHelper;
use olympic\helpers\OlympicHelper;
use dictionary\helpers\DictFacultyHelper;

$this->title = 'Олимпиады и конкурсы МПГУ';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container">
        <h1><?= $this->title ?></h1>
        <div class="row">
            <div class="col-md-4">
                <h5>Для поступающих</h5>
                <?= \yii\jui\Accordion::widget([
                'items' => [
                [
                'header' => '- в бакалавриат',
                'content' => $this->render('_menu',[ 'menu' =>
                    OlympicListHelper::olympicMenu(OlympicHelper::levelOlympicBaccalaureateAll(), DictFacultyHelper::NO_FILIAL),
                        'url'=>'olympiads/baccalaureate']),
                ],
                [
                'header' => '- в магистартуру',
                'content' => $this->render('_menu',[ 'menu'=>
                    OlympicListHelper::olympicMenu(OlympicHelper::FOR_STUDENT, DictFacultyHelper::NO_FILIAL),
                    'url'=>'olympiads/magistracy'])
                ],
                    [
                        'header' => '- в филиал',
                        'content' => $this->render('_menu',[ 'menu'=>
                            OlympicListHelper::olympicMenu(OlympicHelper::levelOlympicAll(), DictFacultyHelper::YES_FILIAL),
                            'url'=>'olympiads/filial'])
                    ],
                ],
                'options' => ['tag' => 'div'],
                'itemOptions' => ['tag' => 'div'],
                'headerOptions' => ['tag' => 'h3'],
                'clientOptions' => ['collapsible' => true, 'active'=>false],
                ]);
                ?>
            </div>
            <div class="col-md-8">
                <?= $this->render('_list', [
                    'dataProvider' => $dataProvider
                ]) ?>
            </div>
        </div>
    </div>
