<?php

namespace dictionary\forms;

use dictionary\models\Country;
use dictionary\models\DictSchools;
use dictionary\models\Region;

class DictSchoolsForm extends \yii\base\Model
{
    public $name, $country_id, $region_id;

    public function __construct(DictSchools $schools = null, $config = [])
    {
        if ($schools) {
            $this->name = $schools->name;
            $this->country_id = $schools->country_id;
            $this->region_id = $schools->region_id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['name'], 'string'],
            ['name', 'unique', 'targetClass' => DictSchools::class, 'message'=> 'Такая учебная организация уже есть в справочнике'],
            [['country_id', 'region_id'], 'integer'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return  DictSchools::labels();
    }


}