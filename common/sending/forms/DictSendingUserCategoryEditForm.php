<?php


namespace common\sending\forms;


use common\sending\models\DictSendingUserCategory;
use common\sending\traits\DictSendingUserCategoryTrait;
use yii\base\Model;

class DictSendingUserCategoryEditForm extends Model
{
    use DictSendingUserCategoryTrait;
    public $dictSendingUserCategory;

    public function __construct(DictSendingUserCategory $dictSendingUserCategory,$config = [])
    {
        $this->name = $dictSendingUserCategory->name;
        $this->dictSendingUserCategory = $dictSendingUserCategory;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => DictSendingUserCategory::class,
                'filter'=>['<>', 'id', $this->dictSendingUserCategory->id],  'message' => 'Название категории должно быть уникальным'],
            [['name'], 'string', 'max' => 255],
        ];
    }

}