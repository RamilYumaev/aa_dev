<?php


namespace modules\dictionary\forms;


use modules\dictionary\models\DictCategory;
use modules\dictionary\models\DictCathedra;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictCathedraForm extends Model
{
    public $name;
    private $_cathedra;


    public function __construct(DictCathedra $cathedra = null, $config = [])
    {
        if ($cathedra) {
            $this->name = $cathedra->name;
            $this->_cathedra = $cathedra;
        }

        parent::__construct($config);
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => DictCathedra::class];
        if ($this->_cathedra) {
            return ArrayHelper::merge($arrayUnique,['filter' => ['<>', 'id', $this->_cathedra->id]]);
        }
        return $arrayUnique;
    }

    public function defaultRules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictCathedra())->attributeLabels();
    }

}