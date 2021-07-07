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

    public function getDictDiscipline()
    {
        return $this->hasOne(DictDiscipline::class,['id' => 'discipline_id']);
    }

    public function getDictDisciplineAlias() {
        return $this->getDictDiscipline()->alias('dict');
    }

    public function getDictDisciplineSelect()
    {
        return $this->hasOne(DictDiscipline::class,['id' => 'discipline_select_id']);
    }

    public static function getOne($disciplineId)
    {
        return self::find()->joinWith(['dictDisciplineSelect', 'dictDisciplineAlias'])
            ->andWhere(['discipline_id' => $disciplineId])
            ->select(['f' => 'dict.ais_id'])
            ->indexBy('dict_discipline.ais_id')->column();
    }
}