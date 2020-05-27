<?php

namespace dictionary\helpers;

use modules\dictionary\models\CathedraCg;
class CathedraCgHelper
{
    public static function cathedraList($id) {
        return CathedraCg::find()->select('cathedra_id')->andWhere(['cg_id'=> $id])->column();
    }


}