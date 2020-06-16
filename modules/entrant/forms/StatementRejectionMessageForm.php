<?php

namespace modules\entrant\forms;

use modules\entrant\models\Statement;
use modules\entrant\models\StatementRejection;
use yii\base\Model;

class StatementRejectionMessageForm extends Model
{
    public $message;

    public function __construct(StatementRejection $file, $config = [])
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
            ['message', 'string'],
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