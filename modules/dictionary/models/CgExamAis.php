<?php

namespace modules\dictionary\models;

use yii\db\ActiveRecord;

class CgExamAis extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%cg_exam_ais}}";
    }
}