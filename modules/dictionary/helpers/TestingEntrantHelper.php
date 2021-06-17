<?php

namespace modules\dictionary\helpers;

use modules\dictionary\models\TestingEntrantDict;
use yii\helpers\Html;
use function Matrix\identity;

class TestingEntrantHelper
{
    public static function images(TestingEntrantDict $model): string
    {
        $images = '';
        $path =\Yii::getAlias('@entrantInfo').'/uploads';
        for ($i = 1; $i <= $model->count_files; $i++) {
            $fileNameWithPath = $path.'/'.$model->getNameFile($i).'.jpg';
            $images .= Html::beginTag('div');
            $images .= Html::beginTag('div',['style' => ['float'=>'left']]);
            $images .= Html::img($fileNameWithPath, ['width'=>100, 'height'=>100, 'style' => ['padding' => '5px']]).'<br/>';
            $images .= Html::a('Удалить',['testing-entrant/image-delete','id'=> $model->id_testing_entrant,
                'dict'=> $model->id_dict_testing_entrant, 'key'=>$i], ['class'=> 'btn btn-danger','style' => ['margin-left' => '5px']]);
            $images .= Html::endTag('div');
            $images .= Html::endTag('div');
        }
        return $images;
    }
}