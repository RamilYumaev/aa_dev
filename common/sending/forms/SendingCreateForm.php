<?php
namespace common\sending\forms;


use common\sending\models\Sending;
use common\sending\traits\SendingTrait;
use yii\base\Model;

class SendingCreateForm  extends Model
{
    use SendingTrait;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'sending_category_id', 'template_id', 'status_id'], 'required'],
            [['sending_category_id', 'template_id', 'status_id', 'type_id',], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['deadline', 'safe'],
            ['name', 'unique', 'targetClass'=>Sending::class,  'targetAttribute' => ['name', 'sending_category_id', 'template_id'], 'message' => 'Такая рассылка уже существует!'],
        ];
    }




}