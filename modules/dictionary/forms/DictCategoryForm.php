<?php


namespace modules\dictionary\forms;


use modules\dictionary\models\DictCategory;
use yii\base\Model;

class DictCategoryForm extends Model
{
    public $name, $foreigner_status;

    private $_category;

    /**
     * DictCategoryForm constructor.
     * @param DictCategory $category
     * @param array $config
     */

    public function __construct(DictCategory $category = null, $config = [])
    {
        if ($category !== null) {
            $this->name = $category->name;
            $this->foreigner_status = $category->foreigner_status;
            $this->_category = $category;
        }

        parent::__construct($config);
    }


    public function uniqueRules()
    {
        if ($this->_category) {
            return [

                [['name'], 'unique', 'targetClass' => DictCategory::class,
                    'filter' => ['<>', 'id', $this->_category->id]],
            ];
        }
        return [[['name'], 'unique', 'targetClass' => DictCategory::class,]];
    }

    public function defaultRules()
    {
        return [
            ['foreigner_status', 'integer'],
            ['name', 'string'],
        ];
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), $this->uniqueRules());
    }

    public function attributeLabels()
    {
        return (new DictCategory())->attributeLabels();
    }

}