<?php
namespace dictionary\forms;

use dictionary\models\DictSpecialization;
use yii\base\Model;

class DictSpecializationForm extends Model
{
    public  $name, $speciality_id;

    public function __construct(DictSpecialization $specialization = null, $config = [])
    {
        if($specialization) {
            $this->name = $specialization->name;
            $this->speciality_id = $specialization->speciality_id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'speciality_id'], 'required'],
            [['speciality_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return  DictSpecialization::labels();
    }

}