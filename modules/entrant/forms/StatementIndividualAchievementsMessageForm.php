<?php


namespace modules\entrant\forms;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use yii\base\Model;

class StatementIndividualAchievementsMessageForm extends Model
{

    public $message;

    public function __construct(StatementIndividualAchievements $file, $config = [])
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