<?php
namespace common\sending\forms;


use common\sending\models\DictSendingTemplate;
use common\sending\models\DictSendingUserCategory;
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
            [['sending_category_id', 'template_id', 'status_id', 'user_id', 'type_id', 'value'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['deadline', 'safe'],
            [['sending_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSendingUserCategory::className(), 'targetAttribute' => ['sending_category_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSendingTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
            ['name', 'unique', 'targetClass'=>Sending::class,  'targetAttribute' => ['name', 'sending_category_id', 'template_id'], 'message' => 'Такая рассылка уже существует!'],
        ];
    }




}