<?php


namespace modules\dictionary\forms;


use modules\dictionary\models\DictOrganizations;
use yii\base\Model;

class DictOrganizationForm extends Model
{
    public $name, $kpp, $ogrn, $region_id, $type;
    private $_organization;
    public $entrant;

    public function __construct(DictOrganizations $organization = null, $entrant = false,  $config = [])
    {
        if ($organization) {
            $this->setAttributes($organization->getAttributes(), false);
            $this->_organization = $organization;
        }
        $this->entrant = $entrant;
        parent::__construct($config);
    }

    public function defaultRules()
    {
        return [
            [['name','ogrn','kpp','region_id'], 'required'],
            [['name','ogrn','kpp'], 'trim'],
            [['type'], $this->entrant ? 'required' : 'safe'],
            [['ogrn'], 'string', 'min'=> 13,'max' =>13],
            [['name'], 'string', 'min'=> 3, 'max' =>255],
            [['kpp'], 'string', 'min'=> 9,'max' =>9],
            [['region_id', 'type'], 'integer'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => DictOrganizations::class, 'targetAttribute'=>['name','kpp', 'ogrn', 'region_id']];
        if ($this->_organization) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_organization->id]]);
        }
        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function typeList() {
        return ['Наниматель', 'Работодатель', 'Наниматель и работодатель'];
    }

    public function attributeLabels()
    {
        return (new DictOrganizations())->attributeLabels();
    }
}