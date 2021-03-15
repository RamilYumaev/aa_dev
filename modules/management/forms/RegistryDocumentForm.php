<?php

namespace modules\management\forms;

use modules\management\models\RegistryDocument;
use yii\base\Model;

class RegistryDocumentForm extends Model
{
    public $name, $link;
    private $_registryDocument;
    public $category_document_id;

    public function __construct(RegistryDocument $registryDocument = null, $config = [])
    {
        if ($registryDocument) {
            $this->setAttributes($registryDocument->getAttributes(), false);
            $this->_registryDocument = $registryDocument;
        }

        parent::__construct($config);
    }
    

    public function rules()
    {
        return [
            [['name', 'link','category_document_id'], 'required'],
            [['name', 'link'], 'string', 'max' => 255],
            [['category_document_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return (new RegistryDocument())->attributeLabels();
    }
}