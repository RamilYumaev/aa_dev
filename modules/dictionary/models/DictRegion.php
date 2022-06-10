<?php

namespace modules\dictionary\models;

use modules\superservice\components\data\RegionList;
use Yii;

/**
 * This is the model class for table "dict_region".
 *
 * @property int $id
 * @property string $name
 * @property int|null $ss_id
 *
 * @property DictOrganizations[] $dictOrganizations
 * @property DictSchools[] $dictSchools
 */
class DictRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','ss_id'], 'required'],
            [['ss_id'], 'integer'],
            [['name','ss_id'], 'unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименвоание',
            'ss_id' => 'ID CC',
            'idSS' => 'ID CC',
        ];
    }

    public function getIdSS()
    {
       return $this->ss_id ? $this->getListSS()[$this->ss_id] : '';
    }

    public function getListSS()
    {
        return (new RegionList())->getDefaultMap();
    }

    /**
     * Gets query for [[DictOrganizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDictOrganizations()
    {
        return $this->hasMany(DictOrganizations::className(), ['region_id' => 'id']);
    }

    /**
     * Gets query for [[DictSchools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDictSchools()
    {
        return $this->hasMany(DictSchools::className(), ['region_id' => 'id']);
    }
}
