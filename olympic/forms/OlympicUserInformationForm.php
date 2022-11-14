<?php
namespace olympic\forms;

use dictionary\models\DictDiscipline;
use olympic\models\UserOlimpiads;
use yii\base\Model;

class OlympicUserInformationForm extends Model
{
    public $subject_one, $subject_two;

    public function __construct(UserOlimpiads $userOlimpiads, $config = [])
    {
        if($userOlimpiads) {
            if($userOlimpiads->information) {
                $information = json_decode($userOlimpiads->information);
                $this->subject_one = $information[0];
                $this->subject_two = $information[1];
            };
        }
         parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_one', 'subject_two'], 'required'],
            [['subject_one', 'subject_two'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
              'subject_one' => 'Предмет №1',
              'subject_two' =>  'Предмет №2'
        ];
    }

    public function subjects() {
        return DictDiscipline::find()
            ->select('name')
            ->andWhere(['is_olympic' => true])
            ->indexBy('id')->column();
    }
}