<?php
namespace modules\entrant\forms;

use modules\entrant\models\PreemptiveRight;
use modules\entrant\models\StatementIa;
use yii\base\Model;

class PreemptiveRightMessageForm extends Model
{

    public $message;

    public function __construct(PreemptiveRight $file, $config = [])
    {
        $this->setAttributes($file->getAttributes(), false);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['message', 'string', 'max'=>255],
            ['message', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [ 'message'=> 'Сообщение'];
    }



}