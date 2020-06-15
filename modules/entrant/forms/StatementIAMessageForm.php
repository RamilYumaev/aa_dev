<?php
namespace modules\entrant\forms;

use modules\entrant\models\StatementIa;
use yii\base\Model;

class StatementIAMessageForm extends Model
{

    public $message;

    public function __construct(StatementIa $file, $config = [])
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