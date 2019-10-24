<?php
namespace olympic\forms\dictionary;

use olympic\models\dictionary\DictSpeciality;
use yii\base\Model;

class DictSpecialityForm extends Model
{
    public $code, $name;

    public function __construct(DictSpeciality $speciality = null, $config = [])
    {
        if($speciality) {
            $this->name = $speciality->name;
            $this->code = $speciality->code;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['name'], 'string'],
            [['code'], 'string', 'max' => 8],
            ['code', 'unique', 'targetClass' => 'backend\models\dictionary\DictSpeciality','message' => 'Такой направление подготовки уже есть'],
        ];
    }

    public function attributeLabels(): array
    {
        return  DictSpeciality::labels();
    }

}