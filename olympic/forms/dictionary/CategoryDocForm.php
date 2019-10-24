<?php
namespace olympic\forms\dictionary;
use backend\helpers\dictionary\CategoryDocHelper;
use backend\models\dictionary\CategoryDoc;
use yii\base\Model;

class CategoryDocForm  extends Model
{
    public $name;
    public $type_id;
    /**
     * {@inheritdoc}
     */
    public function __construct(CategoryDoc $categoryDoc = null, $config = [])
    {
        if($categoryDoc) {
            $this->name = $categoryDoc->name;
            $this->type_id = $categoryDoc->type_id;
        }
        parent::__construct($config);
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'type_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['type_id', 'integer'],
            ['type_id', 'in', 'range' => CategoryDocHelper::categoryDocType(), 'allowArray' => true]
        ];
    }

    public function attributeLabels(): array
    {
        return  CategoryDoc::labels();
    }

    public function categoryTypeList(): array
    {
        return CategoryDocHelper::categoryDocTypeList();
    }


}