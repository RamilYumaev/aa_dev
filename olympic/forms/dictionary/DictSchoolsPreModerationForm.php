<?php


namespace olympic\forms\dictionary;


use olympic\models\dictionary\Country;
use olympic\models\dictionary\DictSchools;
use olympic\models\dictionary\DictSchoolsPreModeration;
use olympic\models\dictionary\Region;
use yii\base\Model;

class DictSchoolsPreModerationForm extends Model
{
    public $name, $country_id, $dict_school_id, $region_id;


    public function __construct(DictSchoolsPreModeration $preModeration = null, $config = [])
    {
        if ($preModeration) {
            $this->name = $preModeration->name;
            $this->dict_school_id = $preModeration->dict_school_id;
            $this->country_id = $preModeration->country_id;
            $this->region_id = $preModeration->region_id;
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
            ['name', 'unique', 'targetClass' => DictSchoolsPreModeration::class, 'message' => 'Такая учебная организация уже есть в справочнике'],
            [['country_id', 'region_id', 'dict_school_id'], 'integer'],
            [['dict_school_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSchools::class, 'targetAttribute' => ['dict_school_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSchoolsPreModeration::labels();
    }


}