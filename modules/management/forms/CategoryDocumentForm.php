<?php

namespace modules\management\forms;


use modules\management\models\CategoryDocument;
use yii\base\Model;

class CategoryDocumentForm extends Model
{
    public $name;
    private $_categoryDocument;
    public function __construct(CategoryDocument $categoryDocument = null, $config = [])
    {
        if ($categoryDocument) {
            $this->setAttributes($categoryDocument->getAttributes(), false);
            $this->_categoryDocument = $categoryDocument;
        }

        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => CategoryDocument::class];
        if ($this->_categoryDocument) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_categoryDocument->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new CategoryDocument())->attributeLabels();
    }
}