<?php

namespace modules\entrant\forms;

use modules\entrant\models\Statement;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use yii\base\Model;

class StatementRejectionCgMessageForm extends Model
{
    public $message;

    public function __construct(StatementRejectionCg $file, $config = [])
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