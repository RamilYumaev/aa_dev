<?php
namespace modules\superservice\forms;
use yii\base\Model;

class SelectTypeDocumentsForm extends Model
{
    public $type;
    public $version;

    private $category;

    public function __construct($category, $config = [])
    {
        $this->category = $category;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
          [['type', 'version'], 'required'],
            [['type', 'type'], 'integer'],
        ];
    }

    public function getDocumentTypeWithCategoryList() {
        return (new \modules\superservice\components\data\DocumentTypeList())
            ->getArray()
            ->sort(['Name'], [SORT_ASC])->filter(function ($v) {
                return in_array($v['IdCategory'], $this->category);
            }, true)
            ->map('Id', 'Name');
    }

    public function attributeLabels()
    {
        return ['type' => 'Тип документа', 'version' => 'Версия документа'];
    }
}
