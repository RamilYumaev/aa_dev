<?php
namespace common\sending\forms;


use common\sending\models\DictSendingTemplate;
use common\sending\models\DictSendingUserCategory;
use common\sending\models\Sending;
use common\sending\traits\SendingTrait;
use yii\base\Model;

class SendingEditForm extends Model
{
    use SendingTrait;
    public $sending;

    public function __construct(Sending $sending, $config = [])
    {
        $this->name = $sending->name;
        $this->status_id = $sending->status_id;
        $this->value = $sending->value;
        $this->sending_category_id = $sending->sending_category_id;
        $this->type_id = $sending->type_id;
        $this->user_id = $sending->user_id;
        $this->template_id = $sending->template_id;
        $this->poll_id = $sending->poll_id;
        $this->deadline = $sending->deadline;
        $this->kind_sending_id = $sending->kind_sending_id;
        $this->sending = $sending;


        parent::__construct($config);
    }

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
            ['name', 'unique', 'targetClass'=>Sending::class, 'filter'=> ['<>', 'id', $this->sending->id],  'targetAttribute' => ['name', 'sending_category_id', 'template_id'], 'message' => 'Такая рассылка уже существует!'],
        ];
    }

}