<?php


namespace modules\dictionary\models;
use dictionary\models\DictCompetitiveGroup;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cathedra_cg}}".
 *
 * @property integer $cathedra_id
 * @property integer $cg_id
 *
 **/

class CathedraCg extends ActiveRecord
{
    public static function create($cathedra_id, $cg_id)
    {
        $cathedraCg = new static();
        $cathedraCg->cathedra_id= $cathedra_id;
        $cathedraCg->cg_id = $cg_id;
        return $cathedraCg;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cathedra_cg}}';
    }

    public function getCathedra()
    {
        return $this->hasOne(DictCathedra::class, ['id'=>'cathedra_id']);
    }

    public function getCompetitiveGroup()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ['id'=>'cg_id']);
    }
}