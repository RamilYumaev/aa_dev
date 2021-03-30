<?php


namespace dictionary\models;

/**
 * This is the model class for table "{{%composite_discipline}}".
 *
 * @property integer $discipline_id
 * @property integer $discipline_select_id
 **/

class CompositeDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'composite_discipline';
    }

    public static function create($disciplineId, $disciplineSelectId): self
    {
        $composite = new static();
        $composite->discipline_id = $disciplineId;
        $composite->discipline_select_id = $disciplineSelectId;
        return $composite;
    }

    public function getDictDisciplineSelect()
    {
        return $this->hasOne(DictDiscipline::class,['id' => 'discipline_select_id']);
    }

}