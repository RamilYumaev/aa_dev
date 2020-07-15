<?php


namespace modules\dictionary\forms;


use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\models\DictOrganizations;
use yii\base\Model;

class DictOrganizationForm extends Model
{
    public $name;
    private $_organization;

    public function __construct(DictOrganizations $organization = null, $config = [])
    {
        if ($organization) {
            $this->setAttributes($organization->getAttributes(), false);
            $this->_organization = $organization;
        }

        parent::__construct($config);
    }

    public function defaultRules()
    {
        return [
            ['name', 'required'],
        ];
    }

    public function uniqueRules()
    {

        $arrayUnique = [['name'], 'unique', 'targetClass' => DictOrganizations::class];
        if ($this->_organization) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_organization->id]]);
        }

        return $arrayUnique;

    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictOrganizations())->attributeLabels();
    }

}